<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ScholarshipMatchMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public Collection $scholarships
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $template = \App\Models\EmailTemplate::getBySlug('scholarship-match');
        
        return new Envelope(
            subject: $template?->subject ?? '🎓 New Scholarship Matches Found for You',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $template = \App\Models\EmailTemplate::getBySlug('scholarship-match');

        return new Content(
            view: 'emails.dynamic',
            with: [
                'content' => \Illuminate\Support\Facades\Blade::render(
                    $template?->content ?? '',
                    ['user' => $this->user, 'scholarships' => $this->scholarships]
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
