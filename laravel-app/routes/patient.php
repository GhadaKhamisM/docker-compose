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
Route::name('patient.')->middleware(['jwt.guard:patient','jwt.auth','auth.check:patient'])->prefix('v1')->group(function () {
    Route::get('services', 'ServiceController@index')->name('services.index');
    Route::get('doctors', 'DoctorController@index')->name('doctors.index');
});