<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

Route::get('/', function () {
    return view('customer.home');
})->name('customer.home');

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

    Route::get('/', function () {

        return view('admin.dashboard');

    })->name('dashboard');


    Route::post(
        '/logout',
        [AdminAuthController::class, 'logout']
    )->name('logout');

});
