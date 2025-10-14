<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\WithdrawalController;
use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\BillPaymentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TwoFactorAuthController;
use App\Http\Controllers\Api\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('verify-2fa', [AuthController::class, 'verify2fa']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('accounts')->group(function () {
        Route::get('/', [AccountController::class, 'index']);
        Route::post('/', [AccountController::class, 'store']);
        Route::get('/{id}', [AccountController::class, 'show']);
        Route::get('/{id}/balance', [AccountController::class, 'balance']);
        Route::get('/{id}/statements', [AccountController::class, 'statements']);
        Route::patch('/{id}', [AccountController::class, 'update']);
    });

    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::get('/{id}', [TransactionController::class, 'show']);
        Route::get('/export/pdf', [TransactionController::class, 'exportPdf']);
        Route::get('/export/csv', [TransactionController::class, 'exportCsv']);
    });

    Route::prefix('withdrawals')->group(function () {
        Route::post('/', [WithdrawalController::class, 'store']);
        Route::get('/', [WithdrawalController::class, 'index']);
        Route::get('/{id}', [WithdrawalController::class, 'show']);
        Route::patch('/{id}/cancel', [WithdrawalController::class, 'cancel']);
    });

    Route::prefix('deposits')->group(function () {
        Route::post('/', [DepositController::class, 'store']);
        Route::get('/', [DepositController::class, 'index']);
        Route::get('/{id}', [DepositController::class, 'show']);
        Route::post('/{id}/confirm', [DepositController::class, 'confirm']);
    });

    Route::prefix('transfers')->group(function () {
        Route::post('/', [TransferController::class, 'store']);
        Route::get('/', [TransferController::class, 'index']);
        Route::get('/{id}', [TransferController::class, 'show']);
        Route::patch('/{id}/cancel', [TransferController::class, 'cancel']);
        Route::post('/schedule', [TransferController::class, 'schedule']);
        Route::get('/beneficiaries', [TransferController::class, 'getBeneficiaries']);
        Route::post('/beneficiaries', [TransferController::class, 'addBeneficiary']);
        Route::delete('/beneficiaries/{id}', [TransferController::class, 'removeBeneficiary']);
    });

    Route::prefix('2fa')->group(function () {
        Route::post('setup', [TwoFactorAuthController::class, 'setup']);
        Route::post('verify-setup', [TwoFactorAuthController::class, 'verifySetup']);
        Route::post('disable', [TwoFactorAuthController::class, 'disable']);
        Route::post('backup-codes', [TwoFactorAuthController::class, 'backupCodes']);
        Route::get('status', [TwoFactorAuthController::class, 'status']);
        Route::post('send-sms-otp', [TwoFactorAuthController::class, 'sendSmsOtp']);
        Route::post('verify-otp', [TwoFactorAuthController::class, 'verifyOtp']);
        Route::get('authorizations/pending', [TwoFactorAuthController::class, 'pendingAuthorizations']);
        Route::post('authorizations/{id}/approve', [TwoFactorAuthController::class, 'approveAuthorization']);
        Route::post('authorizations/{id}/reject', [TwoFactorAuthController::class, 'rejectAuthorization']);
        Route::post('authorizations/{id}/verify-totp', [TwoFactorAuthController::class, 'verifyTotp']);
        Route::post('authorizations/{id}/verify-sms-otp', [TwoFactorAuthController::class, 'verifySmsOtp']);
        Route::post('devices/trusted', [TwoFactorAuthController::class, 'addTrustedDevice']);
        Route::get('devices/trusted', [TwoFactorAuthController::class, 'trustedDevices']);
        Route::delete('devices/{id}', [TwoFactorAuthController::class, 'removeTrustedDevice']);
        Route::post('devices/{id}/forget', [TwoFactorAuthController::class, 'forgetDevice']);
    });

    Route::prefix('bills')->group(function () {
        Route::post('pay', [BillPaymentController::class, 'pay']);
        Route::get('/', [BillPaymentController::class, 'index']);
        Route::get('/{id}', [BillPaymentController::class, 'show']);
        Route::get('/providers', [BillPaymentController::class, 'providers']);
        Route::post('/schedule', [BillPaymentController::class, 'schedule']);
        Route::get('/saved-billers', [BillPaymentController::class, 'savedBillers']);
        Route::post('/saved-billers', [BillPaymentController::class, 'addBiller']);
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('summary', [DashboardController::class, 'summary']);
        Route::get('quick-actions', [DashboardController::class, 'quickActions']);
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [DashboardController::class, 'profile']);
        Route::patch('/', [DashboardController::class, 'updateProfile']);
        Route::post('change-password', [DashboardController::class, 'changePassword']);
        Route::post('enable-2fa', [TwoFactorAuthController::class, 'enable2fa']);
        Route::post('disable-2fa', [TwoFactorAuthController::class, 'disable2fa']);
    });

    Route::prefix('admin')->group(function () {
        Route::get('reports', [AdminController::class, 'reports']);
    });
});
