<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sensor;

class SensorSeeder extends Seeder
{
    public function run()
    {
        $sensors = [
            [
                'name' => 'Fort Area',
                'sensor_id' => 'COL001',
                'latitude' => 6.9271,
                'longitude' => 79.8424,
                'description' => 'Near Colombo Fort Railway Station'
            ],
            [
                'name' => 'Pettah Market',
                'sensor_id' => 'COL002',
                'latitude' => 6.9355,
                'longitude' => 79.8536,
                'description' => 'Near Pettah Market area'
            ],
            [
                'name' => 'Marine Drive',
                'sensor_id' => 'COL003',
                'latitude' => 6.9206,
                'longitude' => 79.8573,
                'description' => 'Along Marine Drive'
            ],
            [
                'name' => 'Bambalapitiya',
                'sensor_id' => 'COL004',
                'latitude' => 6.8992,
                'longitude' => 79.8607,
                'description' => 'Residential area'
            ],
            [
                'name' => 'Narahenpita',
                'sensor_id' => 'COL005',
                'latitude' => 6.9089,
                'longitude' => 79.8702,
                'description' => 'Commercial area'
            ]
        ];

        foreach ($sensors as $sensor) {
            Sensor::create($sensor);
        }
    }
} 