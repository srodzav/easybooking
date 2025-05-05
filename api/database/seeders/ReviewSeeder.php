<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'user_id' => 1,
                'service_id' => 1,
                'reservation_id' => 1,
                'rating' => 5,
                'comment' => 'Excelente servicio, muy recomendable.',
            ],
            [
                'user_id' => 2,
                'service_id' => 2,
                'reservation_id' => 2,
                'rating' => 4,
                'comment' => 'Buen servicio, pero podría mejorar en algunos aspectos.',
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
