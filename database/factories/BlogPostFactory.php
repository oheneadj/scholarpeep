<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'content' => $this->faker->paragraphs(10, true), // Richer content
            'excerpt' => $this->faker->paragraph,
            'featured_image' => 'https://images.unsplash.com/photo-1499750310159-5b5f8c37df85?auto=format&fit=crop&q=80&w=1200', // Generic study image
            'author_id' => \App\Models\User::factory(),
            'is_published' => $this->faker->boolean(90),
            'published_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'is_featured' => $this->faker->boolean(20),
            'views_count' => $this->faker->numberBetween(100, 5000),
            'meta_title' => $title,
            'meta_description' => $this->faker->sentence,
        ];
    }
}
