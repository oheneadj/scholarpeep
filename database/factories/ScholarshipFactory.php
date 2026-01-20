<?php

namespace Database\Factories;

use App\Models\Scholarship;
use App\Enums\SponsorshipTier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ScholarshipFactory extends Factory
{
    protected $model = Scholarship::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->randomNumber(5),
            'description' => $this->faker->paragraph(3),
            'eligibility_criteria' => "- Minimum GPA of 3.5 or equivalent\n- Demonstrated leadership through extracurricular activities\n- Strong commitment to community service\n- Proof of enrollment in an accredited institution",
            'provider_name' => $this->faker->company() . ' Foundation',
            'provider_logo' => 'https://ui-avatars.com/api/?name=' . urlencode($title) . '&background=random',
            'featured_image' => 'https://images.unsplash.com/photo-152305085306e-8c44f2322a5e?auto=format&fit=crop&q=80&w=1200',
            'award_amount' => $this->faker->randomElement([1000, 2500, 5000, 10000, 25000, 50000]),
            'currency' => 'USD',
            'application_url' => 'https://example.com/apply',
            'primary_deadline' => $this->faker->dateTimeBetween('+2 months', '+1 year'),
            'is_rolling' => $this->faker->boolean(20),
            'sponsorship_tier' => $this->faker->randomElement(SponsorshipTier::cases()),
            'sponsorship_start_date' => now(),
            'sponsorship_end_date' => now()->addYear(),
            'meta_title' => $title . ' | Scholarpeep',
            'meta_description' => 'Apply for the ' . $title . ' and unlock your future. Detailed eligibility, deadlines, and application requirements inside.',
            'is_active' => true,
            'status' => \App\Enums\ScholarshipStatus::ACTIVE,
            'views_count' => $this->faker->numberBetween(100, 5000),
            'clicks_count' => $this->faker->numberBetween(10, 1000),
            'applications_count' => $this->faker->numberBetween(0, 500),
        ];
    }

    public function standard()
    {
        return $this->state(fn(array $attributes) => [
            'sponsorship_tier' => SponsorshipTier::STANDARD,
        ]);
    }

    public function featured()
    {
        return $this->state(fn(array $attributes) => [
            'sponsorship_tier' => SponsorshipTier::FEATURED,
        ]);
    }

    public function premium()
    {
        return $this->state(fn(array $attributes) => [
            'sponsorship_tier' => SponsorshipTier::PREMIUM,
        ]);
    }
}
