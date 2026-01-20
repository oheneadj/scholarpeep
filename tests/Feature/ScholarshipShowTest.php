<?php

namespace Tests\Feature;

use App\Models\Scholarship;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Pages\ScholarshipShow;

class ScholarshipShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_renders_successfully()
    {
        $scholarship = Scholarship::factory()->create([
            'status' => \App\Enums\ScholarshipStatus::ACTIVE,
        ]);

        $response = $this->get(route('scholarships.show', $scholarship));

        $response->assertStatus(200);
        $response->assertSee($scholarship->title);
    }

    /** @test */
    public function it_hides_expert_insights_if_no_featured_posts()
    {
        $scholarship = Scholarship::factory()->create([
            'status' => \App\Enums\ScholarshipStatus::ACTIVE,
        ]);

        // Ensure no featured posts exist
        BlogPost::query()->delete();

        Livewire::test(ScholarshipShow::class, ['scholarship' => $scholarship])
            ->assertDontSee('Expert Insights');
    }

    /** @test */
    public function it_shows_expert_insights_if_featured_posts_exist()
    {
        $scholarship = Scholarship::factory()->create([
            'status' => \App\Enums\ScholarshipStatus::ACTIVE,
        ]);

        BlogPost::factory()->create([
            'status' => 'published',
            'is_featured' => true,
            'title' => 'Expert Tip #1'
        ]);

        Livewire::test(ScholarshipShow::class, ['scholarship' => $scholarship])
            ->assertSee('Expert Insights')
            ->assertSee('Expert Tip #1');
    }
}
