<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function getCityFromLocation(Request $request): JsonResponse
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $response = Http::get('https://api.bigdatacloud.net/data/reverse-geocode-client', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'localityLanguage' => 'hu'
        ]);

        $city = $response->json('city');

        return response()->json(['city' => $city]);
    }

    public function storeLocation(Request $request): JsonResponse
    {
        $userId = $request->header('X-User-Id');
        $city = $request->input('city');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Store city and location in the database
        $cityModel = City::firstOrCreate(
            ['name' => $city],
            ['latitude' => $latitude, 'longitude' => $longitude]
        );

        UserLocation::updateOrCreate(
            ['user_id' => $userId],
            ['city_id' => $cityModel->id]
        );

        return response()->json(['message' => 'Location stored', 'cityId' => $cityModel->id]);
    }
}
