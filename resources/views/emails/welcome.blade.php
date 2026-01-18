<x-emails.layout>
    <x-slot name="preheader">
        Welcome to Scholarpeep! We're excited to help you find your next big opportunity.
    </x-slot>

    <h1
        style="color: #111827; font-size: 24px; font-weight: 800; line-height: 1.25; margin: 0 0 20px; text-align: left;">
        Welcome to the family, {{ $user->name }}! 👋
    </h1>

    <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin: 0 0 24px;">
        We're thrilled to have you on board! Scholarpeep is dedicated to connecting students like you with life-changing
        scholarship opportunities worldwide.
    </p>

    <div
        style="background-color: #f3f4f6; border-radius: 16px; padding: 24px; margin-bottom: 32px; border: 1px solid #e5e7eb;">
        <h3 style="color: #111827; font-size: 18px; font-weight: 700; margin: 0 0 12px;">Get started in 3 easy steps:
        </h3>
        <ol style="color: #4b5563; font-size: 14px; line-height: 1.8; padding-left: 20px; margin: 0;">
            <li style="margin-bottom: 8px;"><strong>Complete Your Profile:</strong> Tell us about your academic goals so
                we can find the best matches.</li>
            <li style="margin-bottom: 8px;"><strong>Explore Scholarships:</strong> Browse our curated list of thousands
                of active opportunities.</li>
            <li style="margin-bottom: 0;"><strong>Track Your Apps:</strong> Save scholarships and track your progress in
                your dashboard.</li>
        </ol>
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
</x-emails.layout>