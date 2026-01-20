<?php

namespace Tests\Feature\Livewire;

use App\Enums\ApplicationStatus;
use App\Livewire\Dashboard\ScholarshipStatusUpdate;
use App\Models\SavedScholarship;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ManageStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_component_renders()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(ScholarshipStatusUpdate::class)
            ->assertStatus(200);
    }

    public function test_loads_saved_scholarship_data()
    {
        $user = User::factory()->create();
        $scholarship = Scholarship::factory()->create();
        $saved = SavedScholarship::create([
            'user_id' => $user->id,
            'scholarship_id' => $scholarship->id,
            'status' => ApplicationStatus::SAVED,
            'notes' => 'Existing notes',
        ]);

        $this->actingAs($user);

        Livewire::test(ScholarshipStatusUpdate::class)
            ->call('loadScholarship', $saved->id)
            ->assertSet('savedScholarshipId', $saved->id)
            ->assertSet('status', ApplicationStatus::SAVED->value)
            ->assertSet('notes', 'Existing notes')
            ->assertDispatched('status-update-loaded');
    }

    public function test_updates_status_correctly()
    {
        $user = User::factory()->create();
        $scholarship = Scholarship::factory()->create();
        $saved = SavedScholarship::create([
            'user_id' => $user->id,
            'scholarship_id' => $scholarship->id,
            'status' => ApplicationStatus::SAVED,
        ]);

        $this->actingAs($user);

        Livewire::test(ScholarshipStatusUpdate::class)
            ->call('loadScholarship', $saved->id)
            ->set('status', ApplicationStatus::APPLIED->value)
            ->set('notes', 'New updated notes')
            ->call('updateStatus')
            ->assertDispatched('notify')
            ->assertDispatched('status-updated')
            ->assertDispatched('close-modal');

        $this->assertDatabaseHas('saved_scholarships', [
            'id' => $saved->id,
            'status' => ApplicationStatus::APPLIED->value,
            'notes' => 'New updated notes',
        ]);
    }
}
