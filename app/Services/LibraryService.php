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
    public function createLoan(array $data)
    {
        return DB::transaction(function () use ($data) {
            $dueDate = $data['due_date'] ?? now()->addDays(7);
            
            $loan = Loan::create([
                'user_id' => $data['user_id'],
                'loan_code' => 'LN-' . strtoupper(Str::random(8)),
                'loan_date' => now(),
                'due_date' => $dueDate,
                'status' => 'borrowed', // Could also be 'pending' if it needs pickup
                'total_books' => count($data['book_ids']),
            ]);

            foreach ($data['book_ids'] as $bookId) {
                LoanDetail::create([
                    'loan_id' => $loan->id,
                    'book_id' => $bookId,
                ]);

                // Decrease stock
                $book = Book::find($bookId);
                $book->decrement('available_stock');
            }

            return $loan;
        });
    }

    public function processReturn(Loan $loan, array $data)
    {
        return DB::transaction(function () use ($loan, $data) {
            $returnBook = ReturnBook::create([
                'loan_id' => $loan->id,
                'return_date' => now(),
                'condition' => $data['condition'],
                'notes' => $data['notes'] ?? null,
            ]);

            $loan->update(['status' => 'returned']);

            // Increase stock ONLY if condition is good
            if ($data['condition'] === 'good') {
                foreach ($loan->loanDetails as $detail) {
                    $detail->book->increment('available_stock');
                }
            }

            // Calculate fines if overdue or damaged/lost
            $this->calculateFine($loan, $returnBook);

            return $returnBook;
        });
    }

    protected function calculateFine(Loan $loan, ReturnBook $returnBook)
    {
        $dueDate = Carbon::parse($loan->due_date);
        $returnDate = Carbon::parse($returnBook->return_date);
        
        // 1. Late Fine
        if ($returnDate->greaterThan($dueDate)) {
            $lateFinePerDay = \App\Models\Setting::where('key', 'late_fine_per_day')->value('value') ?? 1000;
            $days = $returnDate->diffInDays($dueDate);
            $amount = $days * $lateFinePerDay;
            
            // Limit amount to avoid extreme values
            $amount = min($amount, 10000000); // Max 10 million late fine per book/loan

            Fine::create([
                'loan_id' => $loan->id,
                'amount' => $amount,
                'type' => 'late',
                'status' => 'unpaid'
            ]);
        }

        // 2. Damage/Lost Fine (Flexible)
        if (in_array($returnBook->condition, ['damaged', 'lost'])) {
            foreach ($loan->loanDetails as $detail) {
                $book = $detail->book;
                $fineAmount = 0;

                if ($book->fine_type === 'fixed') {
                    $fineAmount = (float) filter_var($book->fine_value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                } elseif ($book->fine_type === 'multiplier') {
                    // Extract multiplier value safely (only digits)
                    $multiplierStr = preg_replace('/[^0-9.]/', '', $book->fine_value);
                    $multiplier = (float) ($multiplierStr ?: 1);
                    
                    // price might have thousand separators or be empty, sanitize it
                    $priceStr = filter_var($book->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $price = (float) $priceStr;
                    
                    $fineAmount = $price * $multiplier;
                } else {
                    $fineAmount = (float) filter_var($book->fine_value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                }

                // Sanity check: prevent billions if price or multiplier is wrong
                $fineAmount = min($fineAmount, 50000000); // Cap fine at 50 million to avoid DB errors


                if ($fineAmount > 0) {
                    Fine::create([
                        'loan_id' => $loan->id,
                        'amount' => $fineAmount,
                        'type' => $returnBook->condition,
                        'status' => 'unpaid'
                    ]);
                }
            }
        }
    }

    public function cancelUnclaimedLoans()
    {
        // Cancel loans that are older than 2 days and still in 'borrowed/pending' status
        // AND have not been returned yet. (In this context, we assume borrowed is the initial state)
        $unclaimed = Loan::where('status', 'borrowed')
            ->where('created_at', '<', now()->subDays(2))
            ->get();

        return DB::transaction(function () use ($unclaimed) {
            foreach ($unclaimed as $loan) {
                $loan->update(['status' => 'cancelled']);
                
                // Restock books
                foreach ($loan->loanDetails as $detail) {
                    $detail->book->increment('available_stock');
                }
            }
            return $unclaimed->count();
        });
    }

}
