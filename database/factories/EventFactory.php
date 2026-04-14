<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalSeats = fake()->randomElement([40, 50, 60, 75, 100, 120, 150]);
        $availableSeats = fake()->numberBetween(0, $totalSeats);

        return [
            'title' => fake()->randomElement([
                'Laravel Meetup',
                'Frontend Workshop',
                'Startup Networking Night',
                'Cloud Fundamentals Session',
                'Product Design Circle',
                'Engineering Leadership Talk',
            ]).' '.fake()->city(),
            'description' => fake()->paragraphs(2, true),
            'location' => fake()->randomElement([
                'Karachi',
                'Lahore',
                'Islamabad',
                'Faisalabad',
                'Rawalpindi',
            ]),
            'event_datetime' => fake()->dateTimeBetween('+3 days', '+6 months'),
            'total_seats' => $totalSeats,
            'available_seats' => $availableSeats,
            'created_by' => User::factory(),
        ];
    }
}
