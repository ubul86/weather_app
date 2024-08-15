<?php

namespace App\Jobs;

use App\Models\City;
use App\Services\WeatherService;
use App\Events\WeatherUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchWeatherForCity implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected City $city;
    protected WeatherService $weatherService;

    public function __construct(City $city, WeatherService $weatherService)
    {
        $this->city = $city;
        $this->weatherService = $weatherService;
    }

    public function handle(): void
    {
        \Log::info('Processing city: ' . $this->city->name);

        try {
            $weatherData = $this->weatherService->fetchWeatherData($this->city);

            \Log::info('Weather data fetched for ' . $this->city->name, $weatherData);

            event(new WeatherUpdated($weatherData, $this->city));
            \Log::info('WeatherUpdated event dispatched for ' . $this->city->name);
        } catch (\Exception $e) {
            \Log::error('Failed to fetch weather data for ' . $this->city->name . ': ' . $e->getMessage());
        }
    }
}
