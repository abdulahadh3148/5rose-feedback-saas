<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;

Route::get('/', function () {
    return view('customer.home');
})->name('customer.home');

Route::get('/feedback', function () {
    return view('customer.feedback');
})->name('customer.feedback');

Route::post('/feedback', [FeedbackController::class, 'store'])->name('customer.feedback.store');
