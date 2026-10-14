<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\FeedbackModerationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;

Route::get(
    '/',
    [HomeController::class, 'index']
)->name('customer.home');

Route::get('/feedback', function () {
    return view('customer.feedback');
})->name('customer.feedback');

Route::post('/feedback', [FeedbackController::class, 'store'])->name('customer.feedback.store');

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/login',
    [AdminAuthController::class, 'showLogin']
)->name('admin.login');


Route::post(
    '/admin/login',
    [AdminAuthController::class, 'login']
)->name('admin.login.submit');


Route::middleware([
    'auth',
    'admin',
])->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


    Route::post(
        '/logout',
        [AdminAuthController::class, 'logout']
    )->name('logout');


    Route::get(
        '/feedback',
        [FeedbackModerationController::class, 'index']
    )->name('feedback.index');

    Route::get(
        '/feedback/{feedback}',
        [FeedbackModerationController::class, 'show']
    )->name('feedback.show');

    Route::patch(
        '/feedback/{feedback}/approve',
        [FeedbackModerationController::class, 'approve']
    )->name('feedback.approve');

    Route::patch(
        '/feedback/{feedback}/reject',
        [FeedbackModerationController::class, 'reject']
    )->name('feedback.reject');

    Route::patch(
        '/feedback/{feedback}/pending',
        [FeedbackModerationController::class, 'moveToPending']
    )->name('feedback.pending');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);

    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'store'])->name('pos.store');
    Route::get('/pos/receipt/{order}', [PosController::class, 'receipt'])->name('pos.receipt');

});
