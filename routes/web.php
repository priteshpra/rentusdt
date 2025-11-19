<?php

use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\TransactionController as UserTransactionController;

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

// Route::get('/dashboard', function () {
//     return view('rentus.index');
// })->middleware(['auth'])->name('dashboard');
Route::get('/dashboard', [UserDashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');


Route::post('/deposit', [DepositController::class, 'create'])->middleware('auth:api');

Route::post('/coinpayments/webhook', [WebhookController::class, 'handle']);


Route::get('/payment', [UserTransactionController::class, 'index'])
    ->name('payment');
Route::get('/transactions/filter', [UserTransactionController::class, 'filterTransactions'])
    ->name('transactions.filter');

Route::get('/return', function () {
    return view('rentus.return'); // views/rentus/return.blade.php
})->name('return');

Route::get('/withdraw', function () {
    return view('rentus.withdraw'); // views/rentus/withdraw.blade.php
})->name('withdraw');

Route::get('/profile', function () {
    return view('rentus.profile'); // views/rentus/profile.blade.php
})->name('profile');


//admin panel

Route::get('/admin-dashboard', [DashboardController::class, 'index'])
    ->name('admin-dashboard');

Route::get('/admin/payment', [TransactionController::class, 'index'])
    ->name('admin/payment');
Route::get('/transactions/filter', [TransactionController::class, 'filterTransactions'])
    ->name('transactions.filter');

Route::get('/admin/return', function () {
    return view('admin.return');
})->name('admin/return');

Route::get('/admin/withdraw', function () {
    return view('admin.withdraw');
})->name('admin/withdraw');


Route::resource('users', UserController::class)->names('admin.users');
Route::post('/admin/users/{id}/assign-rate', [UserController::class, 'assignRate'])
    ->name('admin.users.assignRate');

Route::post('/deposit', [DepositController::class, 'depositInsert']);
Route::post('/webhook/nowpayments', [DepositController::class, 'nowPaymentsWebhook']);



require __DIR__ . '/auth.php';
