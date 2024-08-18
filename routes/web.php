<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;


Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::post('/shipping-rate', [HomeController::class, 'getShippingRate'])->name('home.shipping-rate.get');
Route::get('/quick-quote', [HomeController::class, 'getQuickQuote'])->name('home.quick-quote.get');


Route::get('/payment', function () {
    return view('payment');
});
Route::post('/charge', [PaymentController::class, 'charge'])->name('charge');

