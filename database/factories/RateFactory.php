<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Rate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rate>
 */
class RateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' => function () {
                return Hotel::all()->random();
            },
            'date_scraped' => now(),
            'date_of_stay' => $this->faker->dateTimeBetween('+1 day', '+1 year'),
            'rate_per_night' => $this->faker->randomFloat(2, 100, 200),
        ];
    }
}
