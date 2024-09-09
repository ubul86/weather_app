<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Support\Facades\Http;
use App\Repositories\Interfaces\WeatherInterface;

class WeatherRepository implements WeatherInterface
{
    public function fetchWeatherData(City $city): array
    {
        $latitude = $city->latitude;
        $longitude = $city->longitude;

        \Log::info('Processing city: ' . $city->name);

        $response = Http::get("https://api.open-meteo.com/v1/forecast", [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,is_day,precipitation,rain,weather_code,wind_speed_10m',
            'minutely_15' => 'temperature_2m,relative_humidity_2m,rain,wind_speed_10m,is_day',
            'hourly' => 'temperature_2m,relative_humidity_2m,rain,showers,is_day,sunshine_duration',
            'daily' => 'temperature_2m_max,temperature_2m_min,sunrise,sunset',
            'timezone' => 'Europe/London',
            'past_hours' => 24,
            'forecast_hours' => 1,
        ]);

        if ($response->successful()) {
            \Log::info('Weather data fetched for ' . $city->name);
            return $response->json();
        }
        \Log::error('Failed to fetch weather data for ' . $city->name);

        return [];
    }
}
