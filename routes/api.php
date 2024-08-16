<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CityController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/get-city-from-location', [LocationController::class, 'getCityFromLocation']);
Route::post('/store-location', [LocationController::class, 'storeLocation']);

Route::get('/weather/{cityId}', [WeatherController::class, 'getWeatherForCity']);

Route::get('/cities', [CityController::class, 'index']);


Route::middleware('auth.api')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
