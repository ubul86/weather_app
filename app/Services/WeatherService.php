<?php

namespace App\Services;

use App\Models\City;
use App\Repositories\Interfaces\WeatherInterface;
use Illuminate\Http\JsonResponse;

class WeatherService
{
    protected WeatherInterface $weatherRepository;

    public function __construct(WeatherInterface $weatherRepository)
    {
        $this->weatherRepository = $weatherRepository;
    }

    public function fetchWeatherData(City $city): array
    {
        return $this->weatherRepository->fetchWeatherData($city);
    }
}
