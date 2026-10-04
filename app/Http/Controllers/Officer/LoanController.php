<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use App\Services\LibraryService;

class LoanController extends Controller
{
    protected $libraryService;

    public function __construct(LibraryService $libraryService)
    {
        $this->libraryService = $libraryService;
    }

    public function index(Request $request)
    {
        $query = Loan::with(['user', 'loanDetails.book']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('loan_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('loanDetails.book', function ($bq) use ($search) {
                      $bq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('loan_type', $request->type);
        }

        $loans = $query->latest()->paginate(10)->withQueryString();
        return view('officer.loans.index', compact('loans'));
    }

    public function create()
    {
        $borrowers = User::where('role', 'anggota')->get();
        $books = Book::where('available_stock', '>', 0)->get();
        return view('officer.loans.create', compact('borrowers', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required', 
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if ($user && $user->isAdmin()) {
                        $fail('Administrator tidak diperbolehkan meminjam buku.');
                    }
                },
            ],
            'book_ids' => 'required|array|min:1',
            'book_ids.*' => 'exists:books,id',
            'due_date' => 'required|date|after:today|before_or_equal:' . now()->addDays(14)->toDateString(),
        ]);

        try {
            $data = $request->all();
            $data['loan_type'] = $request->input('loan_type', 'physical');

            $this->libraryService->createLoan($data);

            return redirect()->route('admin.loans.index')->with('success', 'Peminjaman berhasil dicatat!');
        } catch (\DomainException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Loan $loan)
    {
        $loan->load(['user', 'loanDetails.book', 'returnBook', 'fine']);
        return view('officer.loans.show', compact('loan'));
    }

    public function returnBook(Request $request, Loan $loan)
    {
        $request->validate([
            'condition' => 'required|in:good,damaged,lost',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->libraryService->processReturn($loan, $request->all());
            return redirect()->route('admin.loans.show', $loan)->with('success', 'Buku berhasil diproses pengembaliannya!');
        } catch (\DomainException $e) {
            return redirect()->route('admin.loans.show', $loan)->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('admin.loans.show', $loan)->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }

    public function payFine(Request $request, Loan $loan)
    {
        $fine = $loan->fine;
        if (!$fine) {
            return redirect()->back()->with('error', 'Tidak ada tagihan denda untuk transaksi peminjaman ini.');
        }

        $request->validate([
            'payment_date' => 'nullable|date',
        ]);

        try {
            $this->libraryService->payFine($fine, $request->all());
            return redirect()->route('admin.loans.show', $loan)->with('success', 'Pembayaran denda sebesar Rp ' . number_format($fine->amount, 0, ',', '.') . ' berhasil dicatat dan dinyatakan LUNAS!');
        } catch (\Exception $e) {
            return redirect()->route('admin.loans.show', $loan)->with('error', $e->getMessage());
        }
    }
}
