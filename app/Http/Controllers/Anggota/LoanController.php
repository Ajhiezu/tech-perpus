<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use App\Services\LibraryService;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    protected $libraryService;

    public function __construct(LibraryService $libraryService)
    {
        $this->libraryService = $libraryService;
    }

    public function index(Request $request)
    {
        $query = Loan::where('user_id', Auth::id())
            ->with(['loanDetails.book', 'returnBook', 'fine']);

        if ($request->filled('type') && in_array($request->type, ['physical', 'digital'])) {
            $query->where('loan_type', $request->type);
        }

        $loans = $query->latest()->paginate(10)->withQueryString();

        return view('member.loans.index', compact('loans'));
    }
    public function store(Request $request)
    {
        $digitalDuration = (int) \App\Models\Setting::get('digital_loan_duration_days', 7);
        $physicalDuration = (int) \App\Models\Setting::get('physical_loan_duration_days', 14);

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'loan_type' => 'required|in:physical,digital',
            'due_date' => 'nullable|date|after:today|before_or_equal:' . now()->addDays($physicalDuration)->toDateString(),
        ]);

        $book = Book::findOrFail($request->book_id);
        $loanType = $request->loan_type;

        // Hybrid availability logic checks
        if ($loanType === 'digital') {
            if (!$book->hasDigital()) {
                if ($book->hasPhysical() && $book->available_stock > 0) {
                    return redirect()->back()->with('error', 'Versi digital buku ini belum tersedia. Buku hanya dapat dipinjam dalam bentuk fisik.');
                }
                return redirect()->back()->with('error', 'Versi digital buku ini belum tersedia.');
            }
            $dueDate = now()->addDays($digitalDuration);
        } else {
            // Physical loan
            if ($book->available_stock <= 0) {
                if ($book->hasDigital()) {
                    return redirect()->back()->with('error', 'Buku fisik tidak tersedia. Versi digital tersedia dan dapat dipinjam untuk dibaca melalui website.');
                }
                return redirect()->back()->with('error', 'Buku sedang tidak tersedia.');
            }
            $dueDate = $request->due_date ?: now()->addDays($physicalDuration);
        }

        try {
            $loan = $this->libraryService->createLoan([
                'user_id' => Auth::id(),
                'book_ids' => [$book->id],
                'loan_type' => $loanType,
                'due_date' => $dueDate,
            ]);

            if ($loanType === 'digital') {
                return redirect()->route('anggota.books.reader', $book)
                    ->with('success', 'Peminjaman digital berhasil diaktifkan! Anda dapat langsung membaca buku di bawah ini.');
            }

            return redirect()->route('anggota.loans.index')
                ->with('success', 'Peminjaman fisik berhasil diajukan! Silakan ambil buku fisik di perpustakaan.');
        } catch (\DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses peminjaman: ' . $e->getMessage());
        }
    }
}
