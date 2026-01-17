<x-emails.layout>
    <x-slot name="preheader">
        Great news! We found new scholarships that match your profile.
    </x-slot>

    <h1
        style="color: #111827; font-size: 24px; font-weight: 800; line-height: 1.25; margin: 0 0 20px; text-align: left;">
        New Scholarship Matches for You! 🎓
    </h1>

    <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin: 0 0 24px;">
        Hello {{ $user->name }}, we've analyzed our database and found <strong>{{ $scholarships->count() }}</strong> new
        opportunities that perfectly align with your academic goals and preferences.
    </p>

    <div style="margin-bottom: 32px;">
        @foreach($scholarships as $scholarship)
            <div
                style="background-color: #fefefe; border: 1px solid #e5e7eb; border-radius: 16px; margin-bottom: 16px; padding: 20px; shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="vertical-align: top;">
                            <h3 style="color: #2563eb; font-size: 18px; font-weight: 700; margin: 0 0 8px;">
                                {{ $scholarship->title }}
                            </h3>
                            <p style="color: #6b7280; font-size: 14px; margin: 0 0 12px;">
                                Provided by <strong>{{ $scholarship->provider_name }}</strong>
                            </p>
                            <div style="color: #111827; font-size: 14px; font-weight: 600;">
                                Amount: {{ $scholarship->currency }} {{ number_format($scholarship->award_amount, 0) }}
                            </div>
                        </td>
                        <td style="text-align: right; vertical-align: top; width: 100px;">
                            <a href="{{ route('scholarships.show', $scholarship) }}"
                                style="background-color: #eff6ff; border-radius: 100px; color: #2563eb; display: inline-block; font-size: 12px; font-weight: 700; padding: 8px 16px; text-decoration: none; text-transform: uppercase; white-space: nowrap;">
                                View Details
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
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
                            <a href="{{ route('dashboard') }}" target="_blank"
                                style="border: solid 1px #2563eb; border-radius: 100px; box-sizing: border-box; color: #ffffff; cursor: pointer; display: inline-block; font-size: 14px; font-weight: 800; margin: 0; padding: 16px 40px; text-decoration: none; text-transform: uppercase; tracking: 0.1em;">
                                Access Your Dashboard
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p style="color: #9ca3af; font-size: 13px; line-height: 1.6; margin: 24px 0 0; text-align: center;">
        Pro-tip: Complete your full profile to get even more accurate matches!
    </p>
</x-emails.layout>