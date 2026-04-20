<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Officer\LoanController as OfficerLoanController;
use App\Http\Controllers\Member\BookController as MemberBookController;

Route::get('/', function () {
    $books = \App\Models\Book::with(['category', 'location'])->latest()->limit(8)->get();
    return view('welcome', compact('books'));
})->name('home');

Route::get('/catalog/{book}', [MemberBookController::class, 'show'])->name('public.books.show');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('locations', LocationController::class);
        Route::resource('books', BookController::class);
        Route::resource('users', UserController::class);
        // Loans Management (Role Specific prefix)
        Route::post('loans/{loan}/return', [OfficerLoanController::class, 'returnBook'])->name('loans.returnBook');
        Route::resource('loans', OfficerLoanController::class);

        // Reports
        Route::get('reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export/pdf', [App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('reports.pdf');
        Route::get('reports/export/excel', [App\Http\Controllers\Admin\ReportController::class, 'exportExcel'])->name('reports.excel');

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });

    Route::get('activities', [App\Http\Controllers\ActivityController::class, 'index'])->name('activities.index');


    // Staff / Petugas Routes
    Route::middleware(['role:admin,staff'])->prefix('staff')->name('staff.')->group(function () {
        Route::resource('books', BookController::class)->only(['index', 'show']);
        Route::post('loans/{loan}/return', [OfficerLoanController::class, 'returnBook'])->name('loans.returnBook');
        Route::resource('loans', OfficerLoanController::class);
    });

    // Member Routes
    Route::middleware(['role:member'])->prefix('member')->name('member.')->group(function () {
        Route::get('books', [MemberBookController::class, 'index'])->name('books.index');
        Route::get('books/{book}', [MemberBookController::class, 'show'])->name('books.show');
        Route::post('loans', [App\Http\Controllers\Member\LoanController::class, 'store'])->name('loans.store');
        Route::get('my-loans', [App\Http\Controllers\Member\LoanController::class, 'index'])->name('loans.index');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
