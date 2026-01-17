<x-emails.layout>
    <x-slot name="preheader">
        Don't miss out! A scholarship deadline is approaching.
    </x-slot>

    <h1
        style="color: #111827; font-size: 24px; font-weight: 800; line-height: 1.25; margin: 0 0 20px; text-align: left;">
        Deadline Reminder: {{ $scholarship->title }} ⏳
    </h1>

    <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin: 0 0 24px;">
        Hello {{ $user->name }}, this is a friendly reminder that the primary deadline for
        <strong>{{ $scholarship->title }}</strong> is approaching in just <strong>{{ $days_left }} days</strong>.
    </p>

    <div
        style="background-color: #fffaf0; border: 1px solid #fbd38d; border-radius: 16px; margin-bottom: 32px; padding: 24px; text-align: center;">
        <div
            style="color: #9c4221; font-size: 14px; font-weight: 800; text-transform: uppercase; tracking: 0.1em; margin-bottom: 8px;">
            Primary Deadline
        </div>
        <div style="color: #111827; font-size: 32px; font-weight: 900; tracking: -0.025em;">
            {{ $scholarship->primary_deadline->format('M d, Y') }}
        </div>
    </div>

    <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary"
        style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
        <tr>
            <td align="center"
                style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                <table border="0" cellpadding="0" cellspacing="0"
                    style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                    <tr>
                        <td
                            style="font-family: sans-serif; font-size: 14px; vertical-align: top; border-radius: 100px; text-align: center; background-color: #2563eb;">
                            <a href="{{ route('scholarships.show', $scholarship) }}" target="_blank"
                                style="border: solid 1px #2563eb; border-radius: 100px; box-sizing: border-box; color: #ffffff; cursor: pointer; display: inline-block; font-size: 14px; font-weight: 800; margin: 0; padding: 16px 40px; text-decoration: none; text-transform: uppercase; tracking: 0.1em;">
                                View Application Details
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin: 32px 0 0; text-align: center;">
        Need help with your application? Check out our <a href="{{ route('resources.index') }}"
            style="color: #2563eb; font-weight: 600; text-decoration: none;">Resource Library</a> for guides and
        templates.
    </p>
</x-emails.layout>