<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Repositories\Interfaces\CityInterface;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    protected CityInterface $cityRepository;

    public function __construct(CityInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function index(): JsonResponse
    {
        $cities = $this->cityRepository->getCities();

        return response()->json([
            'data' => $cities
        ]);
    }
}
