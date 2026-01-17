<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Scholarship;
use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SavedScholarship>
 */
class SavedScholarshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'scholarship_id' => Scholarship::factory(),
            'status' => $this->faker->randomElement(ApplicationStatus::cases()),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
