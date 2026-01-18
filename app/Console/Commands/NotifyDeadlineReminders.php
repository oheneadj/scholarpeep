<?php

namespace App\Console\Commands;

use App\Enums\ApplicationStatus;
use App\Mail\DeadlineReminderMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:deadline-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for approaching scholarship deadlines';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting deadline reminder notifications...');

        User::whereHas('preference', function ($query) {
            $query->where('notify_deadlines', true);
        })->with(['preference', 'savedScholarships' => function ($query) {
            $query->whereIn('status', [ApplicationStatus::SAVED->value, ApplicationStatus::PENDING->value])
                  ->with('scholarship');
        }])->chunk(100, function ($users) {
            foreach ($users as $user) {
                $preferences = $user->preference;
                $reminderDays = $preferences->deadline_reminder_days ?? 7;

                foreach ($user->savedScholarships as $saved) {
                    $scholarship = $saved->scholarship;
                    
                    if (!$scholarship || !$scholarship->primary_deadline) {
                        continue;
                    }

                    $daysLeft = now()->diffInDays($scholarship->primary_deadline, false);

                    // Check if deadline is approaching and within user's window
                    // Also check if we already notified recently to avoid spam (e.g. once per scholarship per window)
                    if ($daysLeft >= 0 && $daysLeft <= $reminderDays && $this->shouldNotify($saved)) {
                        Mail::to($user->email)->send(new DeadlineReminderMail($user, $scholarship, (int) $daysLeft));
                        
                        $saved->forceFill([
                            'last_notified_at' => now(),
                        ])->save();

                        $this->info("Sent deadline reminder to {$user->email} for '{$scholarship->title}'");
                    }
                }
            }
        });

        $this->info('Deadline reminder notifications completed.');
    }

    protected function shouldNotify($savedScholarship)
    {
        // Don't notify more than once every 3 days for the same scholarship
        if (!$savedScholarship->last_notified_at) {
            return true;
        }

        return $savedScholarship->last_notified_at->diffInDays(now()) >= 3;
    }
}
