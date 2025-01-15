<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;

Route::get('/explore/{seller:slug}', [FrontController::class, 'explore'])->name('front.seller');

Route::get('/browse/{category:slug}', [FrontController::class, 'category'])->name('front.category');

Route::get('/details/{ticket:slug}', [FrontController::class, 'details'])->name('front.details');

Route::middleware('auth')->group(function () {
    Route::get('/', [FrontController::class, 'index'])->name('front.index');

    Route::get('/check-booking', [BookingController::class, 'checkBooking'])->name('front.check_booking');
    Route::post('/check-booking/details', [BookingController::class, 'checkBookingDetails'])->name('front.check_booking_details');

    Route::get('/booking/payment', [BookingController::class, 'payment'])->name('front.payment');
    Route::post('/booking/payment', [BookingController::class, 'paymentStore'])->name('front.payment_store');

    Route::get('/booking/{ticket:slug}', [BookingController::class, 'booking'])->name('front.booking');
    Route::post('/booking/{ticket:slug}', [BookingController::class, 'bookingStore'])->name('front.booking_store');

    
    Route::get('/booking/finished/{bookingTransaction}', [BookingController::class, 'bookingFinished'])->name('front.booking_finished');
});


//postman
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/tickets', [TicketController::class, 'index']);
Route::get('/tickets/{id}', [TicketController::class, 'show']);



// Route::get('check-booking', [BookingController::class, 'checkBookingApi']);
// Route::post('check-booking', [BookingController::class, 'checkBookingApi']);


//register login
Route::get('/registerasi', [AuthController::class, 'tampilRegisterasi'])->name('registerasi.tampil');
Route::post('/registerasi/submit', [AuthController::class, 'submitRegisterasi'])->name('registerasi.submit');

Route::get('/login', [AuthController::class, 'tampilLogin'])->name('login');
Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');