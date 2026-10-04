<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanDetail;
use App\Models\ReturnBook;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LibraryService
{
    /**
     * Create a loan transaction (physical or digital).
     *
     * @param array $data
     * @return Loan
     * @throws \DomainException
     */
    public function createLoan(array $data)
    {
        return DB::transaction(function () use ($data) {
            $loanType = $data['loan_type'] ?? 'physical';
            $dueDate = $data['due_date'] ?? now()->addDays(7);
            $userId = $data['user_id'];
            $bookIds = $data['book_ids'];

            // 1. Prevent duplicate active loan for the same book and same loan type
            $existingActiveLoan = Loan::where('user_id', $userId)
                ->where('loan_type', $loanType)
                ->where('status', 'borrowed')
                ->whereHas('loanDetails', function ($q) use ($bookIds) {
                    $q->whereIn('book_id', $bookIds);
                })
                ->exists();

            if ($existingActiveLoan) {
                $formatName = $loanType === 'digital' ? 'versi digital' : 'buku fisik';
                throw new \DomainException("Anda masih memiliki peminjaman aktif untuk {$formatName} buku ini.");
            }

            // 2. Validate availability and handle concurrency
            $booksToLoan = [];
            foreach ($bookIds as $bookId) {
                if ($loanType === 'physical') {
                    // Lock the book row to prevent race conditions on remaining stock
                    $book = Book::where('id', $bookId)->lockForUpdate()->firstOrFail();
                    if ($book->available_stock <= 0) {
                        throw new \DomainException("Buku fisik '{$book->title}' tidak tersedia saat ini. Silakan periksa versi digital jika tersedia.");
                    }
                    $booksToLoan[] = $book;
                } else {
                    // Digital loan: ensure PDF exists
                    $book = Book::findOrFail($bookId);
                    if (!$book->hasDigital()) {
                        throw new \DomainException("Versi digital untuk buku '{$book->title}' belum tersedia.");
                    }
                    $booksToLoan[] = $book;
                }
            }

            // 3. Create Loan Record
            $loan = Loan::create([
                'user_id' => $userId,
                'loan_code' => 'LN-' . strtoupper(Str::random(8)),
                'loan_type' => $loanType,
                'loan_date' => now(),
                'due_date' => $dueDate,
                'status' => 'borrowed',
                'total_books' => count($bookIds),
            ]);

            // 4. Attach Loan Details & decrement stock ONLY if physical
            foreach ($booksToLoan as $book) {
                LoanDetail::create([
                    'loan_id' => $loan->id,
                    'book_id' => $book->id,
                ]);

                if ($loanType === 'physical') {
                    $book->decrement('available_stock');
                }
            }

            return $loan;
        });
    }

    /**
     * Process return of a loan.
     * Prevents double return exploit and handles physical vs digital returns.
     *
     * @param Loan $loan
     * @param array $data
     * @return ReturnBook
     * @throws \DomainException
     */
    public function processReturn(Loan $loan, array $data)
    {
        return DB::transaction(function () use ($loan, $data) {
            // Guard against Double Return exploit
            if ($loan->status === 'returned') {
                throw new \DomainException('Peminjaman ini sudah dikembalikan sebelumnya.');
            }

            $returnBook = ReturnBook::create([
                'loan_id' => $loan->id,
                'return_date' => now(),
                'condition' => $data['condition'] ?? 'good',
                'notes' => $data['notes'] ?? null,
            ]);

            $loan->update(['status' => 'returned']);

            // Increase physical stock ONLY if loan was physical and condition is good
            if ($loan->isPhysical() && ($data['condition'] ?? 'good') === 'good') {
                foreach ($loan->loanDetails as $detail) {
                    $book = Book::where('id', $detail->book_id)->lockForUpdate()->first();
                    if ($book) {
                        $book->increment('available_stock');
                    }
                }
            }

            // Calculate fines only for physical loans
            if ($loan->isPhysical()) {
                $this->calculateFine($loan, $returnBook);
            }

            return $returnBook;
        });
    }

    /**
     * Calculate late or damaged/lost fines for physical loans.
     */
    protected function calculateFine(Loan $loan, ReturnBook $returnBook)
    {
        $dueDate = Carbon::parse($loan->due_date);
        $returnDate = Carbon::parse($returnBook->return_date);

        // 1. Late Fine
        if ($returnDate->greaterThan($dueDate)) {
            $lateFinePerDay = \App\Models\Setting::where('key', 'late_fine_per_day')->value('value') ?? 1000;
            $days = $returnDate->diffInDays($dueDate);
            $amount = $days * $lateFinePerDay;
            $amount = min($amount, 10000000); // Cap fine at 10M

            Fine::create([
                'loan_id' => $loan->id,
                'amount' => $amount,
                'type' => 'late',
                'status' => 'unpaid',
            ]);
        }

        // 2. Damage/Lost Fine
        if (in_array($returnBook->condition, ['damaged', 'lost'])) {
            foreach ($loan->loanDetails as $detail) {
                $book = $detail->book;
                if (!$book) continue;

                $fineAmount = 0;
                if ($book->fine_type === 'fixed') {
                    $fineAmount = (float) filter_var($book->fine_value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                } elseif ($book->fine_type === 'multiplier') {
                    $multiplierStr = preg_replace('/[^0-9.]/', '', $book->fine_value);
                    $multiplier = (float) ($multiplierStr ?: 1);
                    $priceStr = filter_var($book->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $price = (float) $priceStr;
                    $fineAmount = $price * $multiplier;
                } else {
                    $fineAmount = (float) filter_var($book->fine_value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                }

                $fineAmount = min($fineAmount, 50000000); // Cap fine at 50M

                if ($fineAmount > 0) {
                    Fine::create([
                        'loan_id' => $loan->id,
                        'amount' => $fineAmount,
                        'type' => $returnBook->condition,
                        'status' => 'unpaid',
                    ]);
                }
            }
        }
    }

    /**
     * Mark a fine as paid with payment date.
     *
     * @param Fine $fine
     * @param array $data
     * @return Fine
     * @throws \DomainException
     */
    public function payFine(Fine $fine, array $data = [])
    {
        if ($fine->status === 'paid') {
            throw new \DomainException('Tagihan denda ini sudah tercatat lunas sebelumnya.');
        }

        $fine->update([
            'status' => 'paid',
            'payment_date' => $data['payment_date'] ?? now(),
        ]);

        return $fine;
    }

    /**
     * Cancel unclaimed physical loans older than 2 days.
     */
    public function cancelUnclaimedLoans()
    {
        $unclaimed = Loan::where('status', 'borrowed')
            ->where('loan_type', 'physical')
            ->where('created_at', '<', now()->subDays(2))
            ->get();

        return DB::transaction(function () use ($unclaimed) {
            foreach ($unclaimed as $loan) {
                $loan->update(['status' => 'cancelled']);

                foreach ($loan->loanDetails as $detail) {
                    $book = Book::where('id', $detail->book_id)->lockForUpdate()->first();
                    if ($book) {
                        $book->increment('available_stock');
                    }
                }
            }
            return $unclaimed->count();
        });
    }
}
