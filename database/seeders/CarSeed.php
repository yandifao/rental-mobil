<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'name' => 'Toyota Avanza',
                'brand' => 'Toyota',
                'model' => 'MPV',
                'no_plat' => 'B1234ABC',
                'price' => 200000,
            ],
            [
                'name' => 'Honda Jazz',
                'brand' => 'Honda',
                'model' => 'Hatchback',
                'no_plat' => 'B1235ABC',
                'price' => 250000,
            ],
            [
                'name' => 'Suzuki Ertiga',
                'brand' => 'Suzuki',
                'model' => 'MPV',
                'no_plat' => 'B1236ABC',
                'price' => 220000,
            ],
            [
                'name' => 'Daihatsu Xenia',
                'brand' => 'Daihatsu',
                'model' => 'MPV',
                'no_plat' => 'B1237ABC',
                'price' => 210000,
            ],
            [
                'name' => 'Toyota Yaris',
                'brand' => 'Toyota',
                'model' => 'Hatchback',
                'no_plat' => 'B1238ABC',
                'price' => 230000,
            ],
        ];

        foreach ($cars as $car) {
            \App\Models\Cars::create($car);
        }
    }
}
