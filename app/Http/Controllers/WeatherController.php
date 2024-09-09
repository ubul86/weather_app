<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    protected WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getWeatherForCity(int $cityId): JsonResponse
    {
        $city = City::findOrFail($cityId);
        $weatherData = $this->weatherService->fetchWeatherData($city);
        return response()->json([
            'data' => $weatherData
        ]);
    }
}
