<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuccessStory>
 */
class SuccessStoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'scholarship_id' => \App\Models\Scholarship::factory(),
            'title' => $this->faker->sentence,
            'story' => $this->faker->paragraph,
            'student_name' => $this->faker->name,
            'student_photo' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=200',
            'university' => $this->faker->company . ' University',
            'country' => $this->faker->country,
            'is_featured' => $this->faker->boolean(30),
            'is_approved' => true,
        ];
    }
}
