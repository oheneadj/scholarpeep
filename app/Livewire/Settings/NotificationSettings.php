<?php

namespace App\Livewire\Settings;

use App\Enums\NotificationFrequency;
use App\Mail\ScholarshipMatchMail;
use App\Models\EmailTemplate;
use App\Models\Scholarship;
use App\Models\TenantPreference;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class NotificationSettings extends Component
{
    public bool $notify_new_matches = true;
    public bool $notify_deadlines = true;
    public string $notification_frequency = 'daily';
    public int $deadline_reminder_days = 7;

    public bool $showPreviewModal = false;
    public string $previewHtml = '';
    public string $previewSubject = '';

    public function mount()
    {
        $user = Auth::user();
        $preferences = $user->preference ?? new TenantPreference([
            'user_id' => $user->id,
            'notify_new_matches' => true,
            'notify_deadlines' => true,
            'notification_frequency' => NotificationFrequency::DAILY,
            'deadline_reminder_days' => 7,
        ]);

        $this->notify_new_matches = (bool) $preferences->notify_new_matches;
        $this->notify_deadlines = (bool) $preferences->notify_deadlines;
        $this->notification_frequency = $preferences->notification_frequency instanceof NotificationFrequency 
            ? $preferences->notification_frequency->value 
            : ($preferences->notification_frequency ?? 'daily');
        $this->deadline_reminder_days = (int) ($preferences->deadline_reminder_days ?? 7);
    }

    public function saveSettings()
    {
        $user = Auth::user();
        
        TenantPreference::updateOrCreate(
            ['user_id' => $user->id],
            [
                'notify_new_matches' => $this->notify_new_matches,
                'notify_deadlines' => $this->notify_deadlines,
                'notification_frequency' => $this->notification_frequency,
                'deadline_reminder_days' => $this->deadline_reminder_days,
            ]
        );

        $this->dispatch('notify', message: 'Notification settings updated!');
    }

    public function previewTemplate($type)
    {
        $slug = match ($type) {
            'new_match' => 'scholarship-match',
            'deadline' => 'deadline-reminder',
            default => 'scholarship-match',
        };

        $template = EmailTemplate::where('slug', $slug)->first();

        if (!$template) {
            $this->dispatch('notify', message: 'Template not found.', type: 'error');
            return;
        }

        try {
            $data = $this->getMockData($slug);
            $this->previewHtml = Blade::render($template->content, $data);
            $this->previewSubject = Blade::render($template->subject, $data);
            $this->showPreviewModal = true;
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Error rendering preview: ' . $e->getMessage(), type: 'error');
        }
    }

    public function sendTestNotification()
    {
        $user = Auth::user();
        
        // Mock scholarships for the email if user has none
        $scholarships = Scholarship::query()->limit(3)->get();
        
        if ($scholarships->isEmpty()) {
             // Create dummy scholarships in memory for the email
             $scholarships = collect([
                new Scholarship([
                    'title' => 'Global Excellence Scholarship',
                    'provider_name' => 'Education Foundation',
                    'award_amount' => 5000,
                    'currency' => 'USD',
                    'primary_deadline' => now()->addDays(30),
                    'slug' => 'global-excellence-scholarship',
                    'description' => 'A prestigious scholarship for outstanding students.'
                ])
             ]);
        }

        try {
             // We use the Match Mail as the standard test
             Mail::to($user)->send(new ScholarshipMatchMail($user, $scholarships));
             $this->dispatch('notify', message: 'Test notification sent to ' . $user->email);
        } catch (\Exception $e) {
             $this->dispatch('notify', message: 'Failed to send: ' . $e->getMessage(), type: 'error');
        }
    }

    protected function getMockData(string $slug): array
    {
        $user = new User([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            // id is guarded usually, so we rely on default or allow it to be unset
        ]);

        $scholarship = Scholarship::query()->inRandomOrder()->first() ?? new Scholarship([
            'title' => 'Future Leaders Grant',
            'provider_name' => 'Tech Corp',
            'award_amount' => 10000,
            'currency' => 'USD',
            'primary_deadline' => now()->addDays(15),
            'slug' => 'future-leaders-grant',
            'description' => 'Supporting the next generation of tech leaders.'
        ]);

        $scholarships = Scholarship::query()->limit(3)->get();
        if ($scholarships->isEmpty()) {
            $scholarships = collect([$scholarship]);
        }

        return match ($slug) {
            'welcome' => [
                'user' => $user,
            ],
            'scholarship-match' => [
                'user' => $user,
                'scholarships' => $scholarships,
            ],
            'deadline-reminder' => [
                'user' => $user,
                'scholarship' => $scholarship,
                'days_left' => 5,
            ],
            default => [
                'user' => $user,
                'scholarship' => $scholarship,
                'scholarships' => $scholarships,
            ],
        };
    }

    public function render()
    {
        return view('livewire.settings.notification-settings', [
            'frequencies' => NotificationFrequency::cases(),
        ]);
    }
}
