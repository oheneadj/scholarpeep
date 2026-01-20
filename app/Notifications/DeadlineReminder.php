<?php

namespace App\Notifications;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class DeadlineReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public Collection $scholarships;

    /**
     * Create a new notification instance.
     */
    public function __construct(Collection $scholarships)
    {
        $this->scholarships = $scholarships;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $template = EmailTemplate::where('slug', 'deadline-reminder')->first();

        if (!$template) {
            // Fallback content if template is missing
            return (new MailMessage)
                ->subject('Scholarship Deadlines Approaching')
                ->line('You have ' . $this->scholarships->count() . ' scholarship deadlines coming up soon.')
                ->action('View My Applications', route('my-applications'))
                ->line('Don\'t miss out on these opportunities!');
        }

        // Prepare data for the Blade template
        $data = [
            'user' => $notifiable,
            'scholarships' => $this->scholarships,
            'scholarship' => $this->scholarships->first(), // For templates expecting a single 'scholarship' variable
            'days_left' => $this->scholarships->first()->primary_deadline ? now()->diffInDays($this->scholarships->first()->primary_deadline) : 0,
        ];

        try {
            $subject = Blade::render($template->subject, $data);
            $content = Blade::render($template->content, $data);

            return (new MailMessage)
                ->subject($subject)
                ->view('emails.generic', ['content' => new HtmlString($content)]);

        } catch (\Exception $e) {
            // Fallback if rendering fails
             return (new MailMessage)
                ->subject('Scholarship Deadlines Approaching')
                ->line('You have upcoming deadlines. Please check your dashboard.')
                ->action('View My Applications', route('my-applications'));
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
