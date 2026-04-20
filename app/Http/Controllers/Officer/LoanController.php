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

    public function index()
    {
        $loans = Loan::with(['user', 'loanDetails.book'])->latest()->paginate(10);
        return view('officer.loans.index', compact('loans'));
    }

    public function create()
    {
        $borrowers = User::whereIn('role', ['member', 'staff'])->get();
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
                    if ($user && $user->role === 'admin') {
                        $fail('Administrator tidak diperbolehkan meminjam buku.');
                    }
                },
            ],
            'book_ids' => 'required|array|min:1',
            'book_ids.*' => 'exists:books,id',
            'due_date' => 'required|date|after:today|before_or_equal:' . now()->addDays(14)->toDateString(),
        ]);


        $this->libraryService->createLoan($request->all());


        return $this->redirectByRole('success', 'Peminjaman berhasil dicatat!');
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

        $this->libraryService->processReturn($loan, $request->all());

        return $this->redirectByRole('success', 'Buku berhasil dikembalikan!');
    }

    private function redirectByRole($key, $message)
    {
        $prefix = auth()->user()->isAdmin() ? 'admin' : 'staff';
        return redirect()->route($prefix . '.loans.index')->with($key, $message);
    }
}
