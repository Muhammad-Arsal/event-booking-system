<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// Public - anyone can browse events
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Authenticated - only logged-in users can manage events
Route::middleware('auth')->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->whereNumber('event')->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->whereNumber('event')->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->whereNumber('event')->name('events.destroy');
});

Route::get('/events/{event}', [EventController::class, 'show'])->whereNumber('event')->name('events.show');
