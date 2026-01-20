<?php

namespace App\Mail;

use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeadlineReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public Scholarship $scholarship,
        public int $days_left
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $template = \App\Models\EmailTemplate::getBySlug('deadline-reminder');
        $subject = \Illuminate\Support\Facades\Blade::render($template?->subject ?? '', [
            'scholarship' => $this->scholarship,
            'days_left' => $this->days_left,
        ]);

        return new Envelope(
            subject: $subject ?: "⏳ Deadline Reminder: {$this->scholarship->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $template = \App\Models\EmailTemplate::getBySlug('deadline-reminder');

        return new Content(
            view: 'emails.dynamic',
            with: [
                'content' => \Illuminate\Support\Facades\Blade::render(
                    $template?->content ?? '',
                    [
                        'user' => $this->user,
                        'scholarship' => $this->scholarship,
                        'days_left' => $this->days_left
                    ]
                ),
                'preheader' => $template?->preheader,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
