<?php

namespace App\Livewire\Settings;

use App\Enums\NotificationFrequency;
use App\Models\TenantPreference;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class NotificationSettings extends Component
{
    public bool $notify_new_matches = true;
    public bool $notify_deadlines = true;
    public string $notification_frequency = 'daily';
    public int $deadline_reminder_days = 7;

    public function mount()
    {
        $user = Auth::user();
        $preferences = $user->preference ?? new TenantPreference(['user_id' => $user->id]);

        $this->notify_new_matches = $preferences->notify_new_matches;
        $this->notify_deadlines = $preferences->notify_deadlines;
        $this->notification_frequency = $preferences->notification_frequency->value;
        $this->deadline_reminder_days = $preferences->deadline_reminder_days;
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

    public function render()
    {
        return view('livewire.settings.notification-settings', [
            'frequencies' => NotificationFrequency::cases(),
        ]);
    }
}
