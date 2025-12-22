<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Target;

class TargetSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            "COORDENADAS: 10.4806, -66.9036", // Caracas
            "COORDENADAS: 10.4900, -66.8500", // Caracas Este
            "COORDENADAS: 10.4700, -66.9100", // Caracas Oeste
            "COORDENADAS: 40.4167, -3.7037",  // Madrid
            "COORDENADAS: 40.4200, -3.7100",  // Madrid Centro
            "COORDENADAS: 19.4326, -99.1332", // CDMX
            "COORDENADAS: 4.7110, -74.0721",  // Bogotá
            "COORDENADAS: -34.6037, -58.3816", // Buenos Aires
        ];

        foreach ($locations as $loc) {
            Target::create([
                'name' => 'Objetivo de Prueba ' . rand(1, 100),
                'location' => $loc,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'ip' => '127.0.0.1'
            ]);
        }
    }
}