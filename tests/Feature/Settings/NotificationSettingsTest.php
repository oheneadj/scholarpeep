<?php

namespace Tests\Feature\Settings;

use App\Livewire\Settings\NotificationSettings;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_settings_page_is_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('notifications.edit'))
            ->assertOk()
            ->assertSeeLivewire(NotificationSettings::class)
            ->assertSee('Notification Settings');
    }

    public function test_settings_can_be_updated()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NotificationSettings::class)
            ->set('notify_new_matches', false)
            ->set('deadline_reminder_days', 14)
            ->call('saveSettings')
            ->assertDispatched('notify');

        $this->assertDatabaseHas('tenant_preferences', [
            'user_id' => $user->id,
            'notify_new_matches' => 0,
            'deadline_reminder_days' => 14,
        ]);
    }

    public function test_preview_modal_opens_with_content()
    {
        $user = User::factory()->create();
        
        // Create a template
        EmailTemplate::create([
            'name' => 'Scholarship Match',
            'slug' => 'scholarship-match',
            'subject' => 'New Matches for {{ $user->name }}',
            'content' => '<h1>Hello {{ $user->name }}</h1>',
            'preheader' => 'Check matches',
            'is_active' => true,
        ]);

        Livewire::actingAs($user)
            ->test(NotificationSettings::class)
            ->call('previewTemplate', 'new_match')
            ->assertSet('showPreviewModal', true)
            ->assertSee('New Matches for John Doe') // Subject mock
            ->assertSee('Hello John Doe'); // Content mock
    }

    public function test_preview_modal_handles_missing_template()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NotificationSettings::class)
            ->call('previewTemplate', 'non_existent_type')
            ->assertSet('showPreviewModal', false) // Default
            ->assertDispatched('notify'); // Error notification (Template not found for fallback or specific)
            // Wait, logic defaults to 'scholarship-match'. If that's missing, it errors.
            // Our DB is fresh, so it's missing.
    }

    public function test_send_test_notification()
    {
        Mail::fake();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NotificationSettings::class)
            ->call('sendTestNotification')
            ->assertDispatched('notify');

        Mail::assertSent(\App\Mail\ScholarshipMatchMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}
