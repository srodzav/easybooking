<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $reservations = [
            [
                'user_id' => 1,
                'service_id' => 1,
                'start_time' => '2025-05-20 09:00:00',
                'end_time' => '2025-05-20 19:00:00',
                'status' => 'confirmed',
                'notes' => 'Reservación para el servicio 1',
            ],
            [
                'user_id' => 2,
                'service_id' => 2,
                'start_time' => '2025-05-21 09:00:00',
                'end_time' => '2025-05-21 19:00:00',
                'status' => 'pending',
                'notes' => 'Reservación para el servicio 2',
            ],
            [
                'user_id' => 3,
                'service_id' => 3,
                'start_time' => '2025-05-22 09:00:00',
                'end_time' => '2025-05-22 19:00:00',
                'status' => 'pending',
                'notes' => 'Reservación para el servicio 3',
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }
    }
}
