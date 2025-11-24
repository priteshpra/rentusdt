<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\ProfileController as UserProfileController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReturnHistoryController;
use App\Http\Controllers\ReturnHistoryController as UserReturnHistoryController;
use App\Http\Controllers\TransactionController as UserTransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/**
 *
 * Users Route Start
 *
 */

Route::get('/dashboard', [UserDashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::post('/deposit', [DepositController::class, 'create'])->middleware('auth:api');

// Route::post('/coinpayments/webhook', [WebhookController::class, 'handle']);

Route::get('/payment', [UserTransactionController::class, 'index'])
    ->name('payment');
Route::get('/transactions/filter', [UserTransactionController::class, 'filterTransactions'])
    ->name('transactions.filter');

Route::get('/return', [UserReturnHistoryController::class, 'index'])->name('return');
Route::get('/return/filter', [UserReturnHistoryController::class, 'filterTransactions'])
    ->name('return.filter');

Route::get('/withdraw', function () {
    return view('rentus.withdraw'); // views/rentus/withdraw.blade.php
})->name('withdraw');
Route::get('/thank-you', function () {
    return view('rentus.thank-you'); // views/rentus/withdraw.blade.php
})->name('thank-you');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [UserProfileController::class, 'updatePassword'])
        ->name('profile.password.update');
});

Route::post('/deposit', [DepositController::class, 'depositInsert']);
Route::post('/webhook/nowpayments', [DepositController::class, 'nowPaymentsWebhook']);
Route::post('/withdraw/request', [WalletController::class, 'withdrawRequest'])
    ->name('withdraw.request')
    ->middleware('auth');
/**
 *
 * Users Route End
 *
 */


/**
 *
 * Admin Panel Route Start
 *
 */

Route::get('/admin/login', function () {
    return redirect()->route('admin.login');
})->name('admin.dashboard');


Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('adminauth')->group(
    function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::get('/payment', [TransactionController::class, 'index'])
            ->name('admin/payment');
        Route::get('/transactions/filter', [TransactionController::class, 'filterTransactions'])
            ->name('admin.transactions.filter');

        Route::get('/return', [ReturnHistoryController::class, 'index'])->name('admin.return');
        Route::get('/return/filter', [ReturnHistoryController::class, 'filterTransactions'])
            ->name('admin.return.filter');

        Route::get('/withdraw', function () {
            return view('admin.withdraw');
        })->name('admin/withdraw');


        Route::resource('users', UserController::class)->names('admin.users');
        Route::post('/users/{id}/assign-rate', [UserController::class, 'assignRate'])
            ->name('admin.users.assignRate');

        Route::get('/profile', [ProfileController::class, 'show'])->name('admin.profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/profile/update-password', [ProfileController::class, 'admin.updatePassword'])
            ->name('admin.profile.password.update');
    }
);

/**
 *
 * Admin Panel Route End
 *
 */

require __DIR__ . '/auth.php';
