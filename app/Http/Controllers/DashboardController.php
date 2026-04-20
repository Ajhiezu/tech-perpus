<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $stats = [];
        $activities = [];

        if ($user->isAdmin() || $user->isStaff()) {
            $stats = [
                'total_books' => Book::sum('stock'),
                'total_members' => User::where('role', 'member')->count(),
                'active_loans' => Loan::where('status', 'borrowed')->count(),
                'overdue_loans' => Loan::where('status', 'overdue')->count(),
                'total_categories' => Category::count(),
            ];

            // Recent loans for admin/staff
            $activities = Loan::with(['user', 'loanDetails.book'])
                ->latest()
                ->limit(5)
                ->get();
        } else {
            $stats = [
                'my_loans' => Loan::where('user_id', $user->id)->count(),
                'my_borrowed' => Loan::where('user_id', $user->id)->where('status', 'borrowed')->count(),
                'my_overdue' => Loan::where('user_id', $user->id)->where('status', 'overdue')->count(),
            ];

            // Recent books for member to explore
            $activities = Book::with(['category'])->latest()->limit(5)->get();
        }

        return view('dashboard', compact('stats', 'activities'));
    }
}
