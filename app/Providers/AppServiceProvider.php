<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\CityRepository;
use App\Repositories\Interfaces\CityInterface;
use App\Repositories\Interfaces\UserAuthenticationInterface;
use App\Repositories\Interfaces\UserRegistrationInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\WeatherInterface;
use App\Repositories\WeatherRepository;
use App\Services\WeatherService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserRegistrationInterface::class, UserRepository::class);
        $this->app->bind(UserAuthenticationInterface::class, AuthRepository::class);
        $this->app->bind(WeatherInterface::class, WeatherRepository::class);
        $this->app->bind(WeatherService::class, function ($app) {
            return new WeatherService($app->make(WeatherInterface::class));
        });
        $this->app->bind(CityInterface::class, CityRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
