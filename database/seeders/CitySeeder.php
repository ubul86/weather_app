<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run()
    {
        $cities = [
            ['name' => 'Budapest', 'latitude' => 47.4979, 'longitude' => 19.0402],
            ['name' => 'Debrecen', 'latitude' => 47.5316, 'longitude' => 21.6273],
            ['name' => 'Szeged', 'latitude' => 46.253, 'longitude' => 20.1414],
            ['name' => 'Miskolc', 'latitude' => 48.1035, 'longitude' => 20.7784],
            ['name' => 'Pécs', 'latitude' => 46.0727, 'longitude' => 18.2323],
            ['name' => 'Győr', 'latitude' => 47.6875, 'longitude' => 17.6504],
            ['name' => 'Nyíregyháza', 'latitude' => 47.953, 'longitude' => 21.7241],
            ['name' => 'Kecskemét', 'latitude' => 46.9062, 'longitude' => 19.6897],
            ['name' => 'Székesfehérvár', 'latitude' => 47.1944, 'longitude' => 18.4083],
            ['name' => 'Szombathely', 'latitude' => 47.2305, 'longitude' => 16.6218],
            ['name' => 'Szolnok', 'latitude' => 47.1723, 'longitude' => 20.1944],
            ['name' => 'Tatabánya', 'latitude' => 47.5847, 'longitude' => 18.3936],
            ['name' => 'Kaposvár', 'latitude' => 46.3592, 'longitude' => 17.7969],
            ['name' => 'Érd', 'latitude' => 47.3864, 'longitude' => 18.8956],
            ['name' => 'Békéscsaba', 'latitude' => 46.6769, 'longitude' => 21.0906],
            ['name' => 'Veszprém', 'latitude' => 47.0926, 'longitude' => 17.9111],
            ['name' => 'Zalaegerszeg', 'latitude' => 46.8434, 'longitude' => 16.8513],
            ['name' => 'Salgótarján', 'latitude' => 48.0951, 'longitude' => 19.8031],
            ['name' => 'Eger', 'latitude' => 47.9025, 'longitude' => 20.3772],
            ['name' => 'Nagykanizsa', 'latitude' => 46.4537, 'longitude' => 16.9927],
            ['name' => 'Hódmezővásárhely', 'latitude' => 46.419, 'longitude' => 20.3199],
            ['name' => 'Dunaújváros', 'latitude' => 46.963, 'longitude' => 18.9467],
            ['name' => 'Sopron', 'latitude' => 47.6844, 'longitude' => 16.5907],
            ['name' => 'Keszthely', 'latitude' => 46.7677, 'longitude' => 17.2431],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
