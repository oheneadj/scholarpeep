<?php

namespace Database\Factories;

use App\Models\Scholarship;
use App\Enums\RequirementType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScholarshipRequirement>
 */
class ScholarshipRequirementFactory extends Factory
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
            'type' => $this->faker->randomElement(RequirementType::cases()),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'is_required' => $this->faker->boolean(80),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
