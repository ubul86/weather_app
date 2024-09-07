<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RegistrationController;

Route::post('/registration', [RegistrationController::class, 'registration']);

Route::post('/activation', [RegistrationController::class, 'activation'])->name('activate');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/get-city-from-location', [LocationController::class, 'getCityFromLocation']);
Route::post('/store-location', [LocationController::class, 'storeLocation']);

Route::get('/weather/{cityId}', [WeatherController::class, 'getWeatherForCity']);

Route::get('/cities', [CityController::class, 'index']);


Route::middleware('auth.api')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
