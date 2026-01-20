<?php

namespace App\Console\Commands;

use App\Enums\NotificationFrequency;
use App\Enums\ScholarshipStatus;
use App\Mail\ScholarshipMatchMail;
use App\Models\Scholarship;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyUserMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:scholarship-matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications to users for new scholarship matches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting scholarship match notifications...');

        User::whereHas('preference', function ($query) {
            $query->where('notify_new_matches', true);
        })->with('preference')->chunk(100, function ($users) {
            foreach ($users as $user) {
                $preferences = $user->preference;
                
                if (!$this->shouldNotify($preferences)) {
                    continue;
                }

                $matches = $this->findMatchesForUser($user);

                if ($matches->count() > 0) {
                    Mail::to($user->email)->send(new ScholarshipMatchMail($user, $matches));
                    
                    $preferences->forceFill([
                        'last_match_notification_sent_at' => now(),
                    ])->save();

                    $this->info("Sent match notification to {$user->email}");
                }
            }
        });

        $this->info('Scholarship match notifications completed.');
    }

    protected function shouldNotify($preferences)
    {
        $lastSent = $preferences->last_match_notification_sent_at;
        
        if (!$lastSent) return true;

        $now = now();
        
        return match ($preferences->notification_frequency) {
            NotificationFrequency::INSTANT => true, // Instant can run as often as the command runs
            NotificationFrequency::DAILY   => $lastSent->diffInHours($now) >= 23,
            NotificationFrequency::WEEKLY  => $lastSent->diffInDays($now) >= 6,
            default => false,
        };
    }

    protected function findMatchesForUser(User $user)
    {
        $preferences = $user->preference;
        $lastSentAt = $preferences->last_match_notification_sent_at ?? Carbon::now()->subDays(30);

        $query = Scholarship::where('status', '=', ScholarshipStatus::ACTIVE, 'and')
            ->where('created_at', '>', $lastSentAt, 'and');

        // Filter by Country
        if (!empty($preferences->preferred_countries)) {
            $query->whereHas('countries', function ($q) use ($preferences) {
                $q->whereIn('countries.id', $preferences->preferred_countries)
                  ->orWhereIn('countries.code', $preferences->preferred_countries);
            });
        }

        // Filter by Education Level
        if (!empty($preferences->preferred_education_levels)) {
            $query->whereHas('educationLevels', function ($q) use ($preferences) {
                $q->whereIn('education_levels.id', $preferences->preferred_education_levels);
            });
        }

        // Filter by Scholarship Type
        if (!empty($preferences->preferred_scholarship_types)) {
            $query->whereHas('scholarshipTypes', function ($q) use ($preferences) {
                $q->whereIn('scholarship_types.id', $preferences->preferred_scholarship_types);
            });
        }

        return $query->get();
    }
}
