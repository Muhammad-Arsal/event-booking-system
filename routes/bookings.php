<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// All booking actions require authentication
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/events/{event}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->middleware('booking.owner')
        ->name('bookings.cancel');
});
