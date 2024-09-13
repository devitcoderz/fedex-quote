<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\AuthenticationController;

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\BookShipmentController;

use App\Http\Controllers\Admin\DashController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/quick-quote', [HomeController::class, 'getQuickQuote'])->name('home.quick-quote.get');

Route::get('/payment', function () {
    return view('payment');
});
Route::post('/charge', [PaymentController::class, 'charge'])->name('charge');

Route::get("/logout",[AuthenticationController::class,'logout'])->name("logout");

Route::group(['middleware' => 'guest'], function () {
    Route::get("/login",[AuthenticationController::class,'login'])->name("login");
    Route::post("/login",[AuthenticationController::class,'login_submit'])->name("login.submit");
    Route::get("/register",[AuthenticationController::class,'register'])->name("register");
    Route::post("/register",[AuthenticationController::class,'register_submit'])->name("register.submit");
});


Route::middleware(['auth','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',[DashController::class,'dashboard'])->name("dashboard");
    Route::get('shipment/orders',[DashController::class,'shipment_orders'])->name('shipment.orders');
});

Route::middleware(['auth','auth.user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
   
        
    Route::get('/shipment/book', [BookShipmentController::class,'book_shipment'])->name('shipment.book');
    Route::post('/shipment/book/validation/ajax', [BookShipmentController::class,'book_shipment_validation_ajax'])->name('shipment.book.validation.ajax');
    Route::get('get/fedex-location-by-zipcode/ajax',[BookShipmentController::class,'get_fedex_location_by_zipcode_ajax'])->name('get.fedex-location-by-zipcode.ajax');
    Route::post('/shipment/book/rates-and-transit-times/ajax',[BookShipmentController::class,'rates_and_transit_times_ajax'])->name('shipment.book.rates-and-transit-times.ajax');
    Route::post('/shipment/book/checkout/ajax',[BookShipmentController::class,'book_checkout_ajax'])->name('shipment.book.checkout.ajax');
    Route::get('shipment/orders',[BookShipmentController::class,'shipment_orders'])->name('shipment.orders');

    Route::get("/checkout",[BookShipmentController::class,'checkout'])->name("checkout");
    Route::post("/checkout",[BookShipmentController::class,'checkout_submit'])->name("checkout.submit");
    Route::get('/test', [BookShipmentController::class,'test'])->name('test');

});

