<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::name('doctor.')->middleware(['jwt.guard:doctor','auth.jwt','auth.check:doctor','booking.access'])->prefix('v1')->group(function () {    
    Route::get('bookings', 'BookingController@doctorBooking')->name('bookings.list');
    Route::get('bookings/{booking}', 'BookingController@show')->name('bookings.show');
    
    Route::middleware(['booking.status'])->group(function () {
        Route::post('bookings/{booking}/accept', 'BookingController@acceptBooking')->name('bookings.accept');
        Route::post('bookings/{booking}/cancel', 'BookingController@cancelBooking')->name('bookings.cancel');
    });
});