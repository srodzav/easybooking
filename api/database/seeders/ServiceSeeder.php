<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Servicio 1',
                'description' => 'Descripción del servicio 1',
                'business_name' => 'Nombre del negocio 1',
                'location' => 'Ubicación del negocio 1',
                'price' => 100.00,
                'available_from' => '2025-05-20 09:00:00',
                'available_to' => '2025-06-20 17:00:00',
            ],
            [
                'name' => 'Servicio 2',
                'description' => 'Descripción del servicio 2',
                'business_name' => 'Nombre del negocio 2',
                'location' => 'Ubicación del negocio 2',
                'price' => 200.00,
                'available_from' => '2025-05-21 09:00:00',
                'available_to' => '2025-06-21 19:00:00',
            ],
            [
                'name' => 'Servicio 3',
                'description' => 'Descripción del servicio 3',
                'business_name' => 'Nombre del negocio 3',
                'location' => 'Ubicación del negocio 3',
                'price' => 300.00,
                'available_from' => '2025-05-22 09:00:00',
                'available_to' => '2025-06-22 19:00:00',
            ],
        ];
        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
