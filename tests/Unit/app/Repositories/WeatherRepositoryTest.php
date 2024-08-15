<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Models\City;
use App\Repositories\WeatherRepository;

class WeatherRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected WeatherRepository $weatherRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->weatherRepository = new WeatherRepository();
    }

    public function testFetchWeatherDataReturnsDataWhenSuccessful()
    {

        $city = new City([
            'latitude' => 51.5074,
            'longitude' => -0.1278,
            'name' => 'London',
        ]);

        Http::fake([
            'https://api.open-meteo.com/v1/forecast*' => Http::response([
                'temperature_2m' => [15, 16, 17],
                'relative_humidity_2m' => [80, 82, 84],
                'apparent_temperature' => [14, 15, 16],
            ], 200),
        ]);

        $weatherData = $this->weatherRepository->fetchWeatherData($city);

        $this->assertArrayHasKey('temperature_2m', $weatherData);
        $this->assertArrayHasKey('relative_humidity_2m', $weatherData);
        $this->assertArrayHasKey('apparent_temperature', $weatherData);
        $this->assertEquals([15, 16, 17], $weatherData['temperature_2m']);
        $this->assertEquals([80, 82, 84], $weatherData['relative_humidity_2m']);
        $this->assertEquals([14, 15, 16], $weatherData['apparent_temperature']);
    }

    public function testFetchWeatherDataReturnsErrorWhenUnsuccessful()
    {
        $city = new City([
            'latitude' => 51.5074,
            'longitude' => -0.1278,
            'name' => 'London',
        ]);

        Http::fake([
            'https://api.open-meteo.com/v1/forecast*' => Http::response([], 500),
        ]);

        $weatherData = $this->weatherRepository->fetchWeatherData($city);

        $this->assertEquals(['error' => 'Weather data not found'], $weatherData);
    }
}
