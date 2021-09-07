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
Route::name('admin.')->middleware(['jwt.guard:admin','jwt.auth','auth.check:admin'])->prefix('v1')->group(function () {
    Route::resource('services', 'ServiceController');
    Route::resource('doctors', 'DoctorController');
});