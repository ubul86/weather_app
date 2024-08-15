<?php

namespace App\Repositories\Interfaces;

use App\Models\City;
use Illuminate\Http\JsonResponse;

interface WeatherInterface
{
    public function fetchWeatherData(City $city): array;
}
