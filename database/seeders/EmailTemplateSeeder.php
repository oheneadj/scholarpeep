<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Welcome Email',
                'slug' => 'welcome',
                'subject' => '👋 Welcome to Scholarpeep!',
                'preheader' => "Welcome to Scholarpeep! We're excited to help you find your next big opportunity.",
                'content' => <<<'HTML'
                'content' => <<<'HTML'
<div style="text-align: center; margin-bottom: 32px;">
    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&h=200&q=80" alt="Welcome" style="border-radius: 16px; width: 100%; max-width: 600px; height: auto; display: block; margin: 0 auto; object-fit: cover;">
</div>

<h1 style="color: #111827; font-size: 24px; font-weight: 800; line-height: 1.25; margin: 0 0 20px; text-align: left;">
    Welcome to the family, {{ $user->name }}! 👋
</h1>

<p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin: 0 0 24px;">
    We're thrilled to have you on board! Scholarpeep is dedicated to connecting students like you with life-changing
    scholarship opportunities worldwide.
</p>

<div style="background-color: #f3f4f6; border-radius: 16px; padding: 24px; margin-bottom: 32px; border: 1px solid #e5e7eb;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 700; margin: 0 0 12px;">Get started in 3 easy steps:</h3>
    <ol style="color: #4b5563; font-size: 14px; line-height: 1.8; padding-left: 20px; margin: 0;">
        <li style="margin-bottom: 8px;"><strong>Complete Your Profile:</strong> Tell us about your academic goals so we can find the best matches.</li>
        <li style="margin-bottom: 8px;"><strong>Explore Scholarships:</strong> Browse our curated list of thousands of active opportunities.</li>
        <li style="margin-bottom: 0;"><strong>Track Your Apps:</strong> Save scholarships and track your progress in your dashboard.</li>
    </ol>
</div>

<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
    <tr>
        <td align="center" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                <tr>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; border-radius: 100px; text-align: center; background-color: #2563eb;">
                        <a href="{{ route('dashboard') }}" target="_blank" style="border: solid 1px #2563eb; border-radius: 100px; box-sizing: border-box; color: #ffffff; cursor: pointer; display: inline-block; font-size: 14px; font-weight: 800; margin: 0; padding: 16px 40px; text-decoration: none; text-transform: uppercase; tracking: 0.1em;">
                            Go to Your Dashboard
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<p style="color: #4b5563; font-size: 14px; line-height: 1.6; margin: 32px 0 0;">
    If you have any questions, our support team is always here to help. Just reply to this email!
</p>

<p style="color: #111827; font-size: 14px; font-weight: 700; margin: 24px 0 0;">
    Best of luck,<br>
    The Scholarpeep Team
</p>
HTML,
                'description' => 'Sent to users immediately after registration.',
            ],
            [
                'name' => 'Scholarship Match',
                'slug' => 'scholarship-match',
                'subject' => '🎓 New Scholarship Matches Found for You',
                'preheader' => 'Great news! We found new scholarships that match your profile.',
                'content' => <<<'HTML'
<div style="text-align: center; margin-bottom: 24px;">
    <span style="display: inline-block; padding: 8px 16px; background-color: #eff6ff; color: #2563eb; border-radius: 100px; font-size: 12px; font-weight: 700; text-transform: uppercase; tracking: 1px;">Weekly Matches</span>
</div>

<h1 style="color: #111827; font-size: 28px; font-weight: 800; line-height: 1.2; margin: 0 0 20px; text-align: center; letter-spacing: -0.02em;">
    {{ $scholarships->count() }} New Matches! 🎯
</h1>

<p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin: 0 0 32px; text-align: center;">
    Hello {{ $user->name }}, we've hand-picked these opportunities for you based on your profile.
</p>

<!-- SCHOLARSHIP CARDS -->
<div>
    @foreach($scholarships as $index => $scholarship)
        <div style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);">
            <!-- COVER IMAGE (Random Education Image) -->
            <div style="height: 160px; overflow: hidden; background-color: #f3f4f6; position: relative;">
                 @php
                    $images = [
                        'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=600&h=320&fit=crop',
                        'https://images.unsplash.com/photo-1535982330050-f1c2fb9705f0?w=600&h=320&fit=crop',
                        'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&h=320&fit=crop'
                    ];
                    $image = $images[$index % count($images)];
                 @endphp
                <img src="{{ $image }}" alt="{{ $scholarship->title }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                
                @if($scholarship->award_amount)
                <div style="position: absolute; top: 12px; right: 12px; background-color: #ffffff; padding: 6px 12px; border-radius: 100px; font-weight: 700; color: #16a34a; font-size: 13px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    {{ $scholarship->currency }} {{ number_format($scholarship->award_amount, 0) }}
                </div>
                @endif
            </div>

            <!-- CARD BODY -->
            <div style="padding: 24px;">
                <!-- PROVIDER WITH LOGO -->
                <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 12px;">
                    <tr>
                        <td style="padding-right: 10px;">
                            <img src="{{ $scholarship->provider_logo ?? 'https://ui-avatars.com/api/?name='.urlencode($scholarship->provider_name).'&background=random' }}" alt="{{ $scholarship->provider_name }}" style="width: 32px; height: 32px; border-radius: 50%; display: block;">
                        </td>
                        <td>
                            <span style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase;">{{ $scholarship->provider_name }}</span>
                        </td>
                    </tr>
                </table>

                <h3 style="color: #111827; font-size: 20px; font-weight: 700; margin: 0 0 12px; line-height: 1.4;">
                    {{ $scholarship->title }}
                </h3>

                <p style="color: #4b5563; font-size: 14px; line-height: 1.6; margin: 0 0 20px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                   {{ Str::limit($scholarship->description, 100) }}
                </p>

                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="vertical-align: middle;">
                            @if($scholarship->primary_deadline)
                            <div style="font-size: 13px; color: #dc2626; font-weight: 600;">
                                ⏳ {{ $scholarship->primary_deadline->format('M d, Y') }}
                            </div>
                            @endif
                        </td>
                        <td style="text-align: right;">
                             <a href="{{ route('scholarships.show', $scholarship) }}" style="background-color: #2563eb; color: #ffffff; border-radius: 8px; display: inline-block; font-size: 14px; font-weight: 600; padding: 10px 20px; text-decoration: none;">
                                View Details &rarr;
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endforeach
</div>

<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box; margin-top: 20px;">
    <tr>
        <td align="center" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
            <a href="{{ route('dashboard') }}" target="_blank" style="background-color: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; border-radius: 100px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: 600; margin: 0; padding: 14px 30px; text-decoration: none;">
                See All Matches in Dashboard
            </a>
        </td>
    </tr>
</table>
HTML,
                'description' => 'Sent weekly or monthly with new matches.',
            ],
            [
                'name' => 'Deadline Reminder',
                'slug' => 'deadline-reminder',
                'subject' => "⏳ Deadline Reminder: {{ \$scholarship->title }}",
                'preheader' => "Don't miss out! A scholarship deadline is approaching.",
                'content' => <<<'HTML'
<div style="background-color: #fff1f2; border: 1px solid #fecdd3; border-radius: 16px; padding: 32px; text-align: center; margin-bottom: 32px;">
    <div style="font-size: 64px; line-height: 1; margin-bottom: 16px;">⏳</div>
    <h1 style="color: #be123c; font-size: 24px; font-weight: 800; line-height: 1.25; margin: 0 0 8px;">
        Deadline Approaching!
    </h1>
    <p style="color: #9f1239; font-size: 16px; margin: 0;">
        Only <strong>{{ $days_left }} days</strong> left to apply.
    </p>
</div>

<div style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; margin-bottom: 24px;">
    <div style="padding: 24px;">
        <h2 style="margin: 0 0 12px; font-size: 22px; color: #111827;">{{ $scholarship->title }}</h2>
        <div style="color: #6b7280; margin-bottom: 20px;">Provided by {{ $scholarship->provider_name }}</div>
        
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
            <tr>
                <td align="center">
                    <a href="{{ route('scholarships.show', $scholarship) }}" style="background-color: #be123c; color: #ffffff; border-radius: 100px; display: inline-block; font-size: 16px; font-weight: 700; padding: 14px 32px; text-decoration: none; width: 100%; box-sizing: border-box; text-align: center;">
                        Apply Now
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>

<p style="color: #4b5563; font-size: 14px; line-height: 1.6; margin: 0 0 24px; text-align: center;">
    Review the requirements and submit your application before <strong>{{ $scholarship->primary_deadline->format('M d, Y') }}</strong>.
</p>

<p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin: 32px 0 0; text-align: center;">
    Need help with your application? Check out our <a href="{{ route('resources.index') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">Resource Library</a> for guides.
</p>
HTML,
                'description' => 'Sent few days before the primary deadline.',
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }
}
