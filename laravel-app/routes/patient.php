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
Route::name('patient.')->middleware(['jwt.guard:patient'])->prefix('v1')->group(function () {
    Route::get('services', 'ServiceController@index')->name('services.index');
    Route::get('doctors', 'DoctorController@index')->name('doctors.index');
    Route::get('doctors/{doctor}', 'DoctorController@show')->name('doctors.show');
    
    Route::middleware(['auth.jwt','auth.check:patient','booking.access'])->group(function () {
        Route::get('doctors/{doctor}/days', 'DoctorController@getDoctorAvailableDates')->name('doctors.dates');
        Route::post('bookings', 'BookingController@store')->name('bookings.store');
        Route::get('bookings/{booking}', 'BookingController@show')->name('bookings.show');
        Route::get('bookings', 'BookingController@patientBooking')->name('bookings.list');
    });
});