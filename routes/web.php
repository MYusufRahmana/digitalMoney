<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Dashboard Transaction Routes
    Route::post('/dashboard/transaction', [DashboardController::class, 'storeTransaction'])->name('dashboard.transaction.store');
    Route::delete('/dashboard/transaction/{transaction}', [DashboardController::class, 'destroyTransaction'])->name('dashboard.transaction.destroy');
    Route::put('/dashboard/transaction/{transaction}', [DashboardController::class, 'updateTransaction'])->name('dashboard.transaction.update');

    // Transactions
    Route::resource('transactions', TransactionController::class);

    // // Accounts
    // Route::resource('accounts', AccountController::class);
    // Route::post('/accounts/{account}/toggle', [AccountController::class, 'toggleStatus'])->name('accounts.toggle');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
