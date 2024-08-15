<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use App\Jobs\FetchWeatherForCity;
use App\Services\WeatherService;

class DispatchWeatherJobs extends Command
{
    protected $signature = 'weather:dispatch';
    protected $description = 'Dispatch weather fetching jobs for each city';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $cities = City::all();
        $weatherService = app(WeatherService::class);
        foreach ($cities as $city) {
            FetchWeatherForCity::dispatch($city, $weatherService);
            \Log::info("Dispatched weather job for city: {$city->name}");
        }
        $this->info('Weather jobs dispatched for all cities.');
        \Log::info('Weather jobs dispatched for all cities.');
    }
}
