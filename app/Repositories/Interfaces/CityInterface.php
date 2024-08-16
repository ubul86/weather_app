<?php

namespace App\Repositories\Interfaces;

use App\Models\City;
use Illuminate\Http\JsonResponse;

interface CityInterface
{
    public function getCities(): array;
}
