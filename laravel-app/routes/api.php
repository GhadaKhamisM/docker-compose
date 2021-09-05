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
Route::name('auth.')->prefix('v1')->group(function () {
        Route::post('patients/register', 'Auth\RegisterController@patientRegistration')->name('patient-register');
        Route::post('patients/login','Auth\LoginController@patientLogin')->name('patient-login');     
        Route::post('admins/login','Auth\LoginController@adminLogin')->name('admin-login');   
});