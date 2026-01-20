<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\DeadlineReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scholarpeep:send-deadline-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send deadline reminders to users for saved scholarships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting deadline reminders check...');
        
        $users = User::whereHas('preference', function ($query) {
            $query->where('notify_deadlines', true);
        })->with('preference')->get();

        $count = 0;

        foreach ($users as $user) {
            $days = $user->preference->deadline_reminder_days ?? 7;
            
            // Should typically only send once a day. 
            // If we sent one today already, skip.
            if ($user->preference->last_deadline_notification_sent_at && 
                $user->preference->last_deadline_notification_sent_at->isToday()) {
                continue;
            }

            // Find scholarships expiring within the window (+/- 1 day to catch "exactly 7 days" or "within window")
            // Actually, for a daily digest, we probably want "Expiring in exactly X days" OR "Expiring in <= X days".
            // Let's do: Expiring between now and X days.
            
            $scholarships = $user->savedScholarships()
                ->whereIn('status', ['saved', 'pending']) // Only warn about un-applied or pending ones? Or just saved? Maybe pending too requires action.
                ->whereHas('scholarship', function ($q) use ($days) {
                    $q->whereBetween('primary_deadline', [now(), now()->addDays($days)])
                      ->where('primary_deadline', '>', now()); // Ensure not already passed
                })
                ->with('scholarship')
                ->get()
                ->map(fn($saved) => $saved->scholarship);

            if ($scholarships->isNotEmpty()) {
                try {
                    $user->notify(new DeadlineReminder($scholarships));
                    
                    $user->preference->last_deadline_notification_sent_at = now();
                    $user->preference->save();
                    
                    $count++;
                    $this->info("Sent reminder to user ID {$user->id} for {$scholarships->count()} scholarships.");
                } catch (\Exception $e) {
                    Log::error("Failed to send deadline reminder to user {$user->id}: " . $e->getMessage());
                    $this->error("Failed to send to user {$user->id}");
                }
            }
        }

        $this->info("Deadline reminders sent to {$count} users.");
    }
}
