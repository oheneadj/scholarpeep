<?php

namespace Database\Factories;

use App\Models\Scholarship;
use App\Enums\DeadlineType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScholarshipDeadline>
 */
class ScholarshipDeadlineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scholarship_id' => Scholarship::factory(),
            'type' => $this->faker->randomElement(DeadlineType::cases()),
            'date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'description' => $this->faker->sentence(),
        ];
    }
}
