<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Interfaces\CityInterface;

class CityRepository implements CityInterface
{
    public function getCities(): array
    {
        $cities = City::all()->toArray();
        return $cities;
    }
}
