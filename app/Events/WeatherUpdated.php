<?php

namespace App\Events;

use App\Models\City;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WeatherUpdated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public array $weatherData;

    public City $city;

    public function __construct(array $weatherData, City $city)
    {
        $this->weatherData = $weatherData;
        $this->city = $city;
    }

    public function broadcastOn()
    {
        return new Channel('weather-channel.' . $this->city->id);
    }

    public function broadcastAs(): string
    {
        return 'weather.updated';
    }
}
