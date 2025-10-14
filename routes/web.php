<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TwoFactorAuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transfers', [DashboardController::class, 'transfers'])->name('transfers');
    Route::get('/bill-payments', [DashboardController::class, 'billPayments'])->name('bill-payments');
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
    Route::get('/accounts', [DashboardController::class, 'accounts'])->name('accounts');
    Route::get('/statistics', [DashboardController::class, 'statistics'])->name('statistics');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/2fa/setup', [TwoFactorAuthController::class, 'setup'])->name('2fa.setup');
    Route::post('/2fa/verify', [TwoFactorAuthController::class, 'verifySetup'])->name('2fa.verify');
    Route::get('/2fa/disable', [TwoFactorAuthController::class, 'disable'])->name('2fa.disable');
});

require __DIR__.'/auth.php';