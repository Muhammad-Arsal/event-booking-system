<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'event_id' => Event::factory(),
            'seats_booked' => fake()->numberBetween(1, 4),
            'status' => fake()->randomElement(['booked', 'cancelled']),
            'booking_date' => fake()->dateTimeBetween('-45 days', 'now'),
        ];
    }
}
