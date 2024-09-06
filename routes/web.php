<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\AuthenticationController;

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\BookShipmentController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/quick-quote', [HomeController::class, 'getQuickQuote'])->name('home.quick-quote.get');

// Route::get('/payment', function () {
//     return view('payment');
// });
// Route::post('/charge', [PaymentController::class, 'charge'])->name('charge');

Route::get("/logout",[AuthenticationController::class,'logout'])->name("logout");

Route::group(['middleware' => 'guest'], function () {
    Route::get("/login",[AuthenticationController::class,'login'])->name("login");
    Route::post("/login",[AuthenticationController::class,'login_submit'])->name("login.submit");
    Route::get("/register",[AuthenticationController::class,'register'])->name("register");
    Route::post("/register",[AuthenticationController::class,'register_submit'])->name("register.submit");
});


Route::middleware(['auth','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',function(){
        return view('admin.dashboard');
    })->name("dashboard");
});

Route::middleware(['auth','auth.user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    
    Route::get('/shipment/book', [BookShipmentController::class,'book_shipment'])->name('shipment.book');
    Route::post('/shipment/book/validation/ajax', [BookShipmentController::class,'book_shipment_validation_ajax'])->name('shipment.book.validation.ajax');
    Route::get('get/fedex-location-by-zipcode/ajax',[BookShipmentController::class,'get_fedex_location_by_zipcode_ajax'])->name('get.fedex-location-by-zipcode.ajax');
    Route::get('/test', [BookShipmentController::class,'test'])->name('test');
});

