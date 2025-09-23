<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShuttleRoute;

class ShuttleRouteSeeder extends Seeder
{
    public function run()
    {
        $routes = [
            // Shuttle Pulang Routes
            [
                'name' => 'Shuttle Pulang Jakarta Pusat',
                'destination' => 'Jakarta Pusat',
                'description' => 'Bundaran HI, Sarinah, Plaza Indonesia',
                'shuttle_type' => 'pulang',
                'departure_time' => '17:00:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Pulang Jakarta Selatan',
                'destination' => 'Jakarta Selatan',
                'description' => 'Blok M, Senayan, Kemang, Pondok Indah',
                'shuttle_type' => 'pulang',
                'departure_time' => '17:30:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Pulang Jakarta Barat',
                'destination' => 'Jakarta Barat',
                'description' => 'Kebon Jeruk, Slipi, Grogol, Taman Anggrek',
                'shuttle_type' => 'pulang',
                'departure_time' => '17:00:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Pulang Jakarta Utara',
                'destination' => 'Jakarta Utara',
                'description' => 'Kelapa Gading, Sunter, Pantai Indah Kapuk',
                'shuttle_type' => 'pulang',
                'departure_time' => '17:15:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Pulang Bekasi',
                'destination' => 'Bekasi',
                'description' => 'Bekasi Timur, Bekasi Selatan, Galaxy Mall',
                'shuttle_type' => 'pulang',
                'departure_time' => '17:00:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Pulang Tangerang',
                'destination' => 'Tangerang',
                'description' => 'BSD, Gading Serpong, Alam Sutera',
                'shuttle_type' => 'pulang',
                'departure_time' => '17:30:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Pulang Depok',
                'destination' => 'Depok',
                'description' => 'UI, Margonda, Cinere, Bojong Gede',
                'shuttle_type' => 'pulang',
                'departure_time' => '17:15:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Pulang Bogor',
                'destination' => 'Bogor',
                'description' => 'Bogor Tengah, Botani Square, Tajur',
                'shuttle_type' => 'pulang',
                'departure_time' => '17:00:00',
                'capacity' => 40,
                'is_active' => true,
            ],

            // Shuttle Kembali Routes (Sunday/Holiday)
            [
                'name' => 'Shuttle Kembali Kp. Rambutan',
                'destination' => 'Terminal Kampung Rambutan',
                'description' => 'Pick up point dari berbagai daerah Jakarta Timur dan Selatan',
                'shuttle_type' => 'kembali',
                'departure_time' => '18:00:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Kembali Blok M',
                'destination' => 'Terminal Blok M',
                'description' => 'Pick up point dari berbagai daerah Jakarta Selatan',
                'shuttle_type' => 'kembali',
                'departure_time' => '18:30:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Kembali Kalideres',
                'destination' => 'Terminal Kalideres',
                'description' => 'Pick up point dari berbagai daerah Jakarta Barat',
                'shuttle_type' => 'kembali',
                'departure_time' => '18:00:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Kembali Bekasi',
                'destination' => 'Stasiun Bekasi',
                'description' => 'Pick up point dari Bekasi dan sekitarnya',
                'shuttle_type' => 'kembali',
                'departure_time' => '18:15:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Kembali BSD',
                'destination' => 'Terminal BSD',
                'description' => 'Pick up point dari Tangerang Selatan',
                'shuttle_type' => 'kembali',
                'departure_time' => '18:30:00',
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Shuttle Kembali Depok',
                'destination' => 'Stasiun Depok',
                'description' => 'Pick up point dari Depok dan sekitarnya',
                'shuttle_type' => 'kembali',
                'departure_time' => '18:00:00',
                'capacity' => 40,
                'is_active' => true,
            ],
        ];

        foreach ($routes as $route) {
            ShuttleRoute::create($route);
        }
    }
}
