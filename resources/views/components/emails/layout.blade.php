<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
                font-size: 16px !important;
            }

            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 10px !important;
            }

            table[class=body] .content {
                padding: 0 !important;
            }

            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }

            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            table[class=body] .btn table {
                width: 100% !important;
            }

            table[class=body] .btn a {
                width: 100% !important;
            }

            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }
        }

        @media all {
            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }

            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
                font-size: inherit;
                font-family: inherit;
                font-weight: inherit;
                line-height: inherit;
            }

            .btn-primary table td:hover {
                background-color: #1d4ed8 !important;
            }

            .btn-primary a:hover {
                background-color: #1d4ed8 !important;
                border-color: #1d4ed8 !important;
            }

            h1 {
                font-family: 'Outfit', sans-serif !important;
                font-weight: 700 !important;
                color: #111827 !important;
                font-size: 24px !important;
                margin-bottom: 24px !important;
                line-height: 1.25 !important;
            }

            h2 {
                font-family: 'Outfit', sans-serif !important;
                font-weight: 600 !important;
                color: #1f2937 !important;
                font-size: 20px !important;
                margin-top: 32px !important;
                margin-bottom: 16px !important;
            }

            p {
                margin-bottom: 24px !important;
            }
        }
    </style>
    <!-- PRE-LOAD FONTS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body
    style="background-color: #f9fafb; font-family: 'Inter', system-ui, -apple-system, sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
    <table border="0" cellpadding="0" cellspacing="0" class="body"
        style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f9fafb;">
        <tr>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
            <td class="container"
                style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                <div class="content"
                    style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">

                    <!-- START CENTERED WHITE CONTAINER -->
                    <span class="preheader"
                        style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">{{ $preheader ?? '' }}</span>

                    <!-- LOGO -->
                    <div style="padding: 20px 0; text-align: center;">
                        <a href="{{ config('app.url') }}" style="text-decoration: none;">
                            <span
                                style="color: #2563eb; font-size: 24px; font-weight: 800; tracking: -0.025em;">Scholar<span
                                    style="color: #9333ea;">peep</span></span>
                        </a>
                    </div>

                    <table class="main"
                        style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                        <!-- BRAND ACCENT BAR -->
                        <tr>
                            <td
                                style="background: linear-gradient(90deg, #2563eb 0%, #9333ea 100%); height: 6px; font-size: 0; line-height: 0;">
                                &nbsp;</td>
                        </tr>
                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class="wrapper"
                                style="font-family: 'Inter', sans-serif; font-size: 16px; line-height: 1.6; vertical-align: top; box-sizing: border-box; padding: 40px; color: #374151;">
                                <table border="0" cellpadding="0" cellspacing="0"
                                    style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                    <tr>
                                        <td
                                            style="font-family: 'Inter', sans-serif; font-size: 16px; vertical-align: top;">
                                            {{ $slot }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- MARKETING / DISCOVERY SECTION -->
                        <tr>
                            <td style="background-color: #f3f4f6; padding: 30px 40px; border-top: 1px solid #e5e7eb;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="text-align: center; padding-bottom: 20px;">
                                            <h3
                                                style="margin: 0; font-family: 'Outfit', sans-serif; font-size: 18px; color: #111827; font-weight: 600;">
                                                Unleash Your Potential 🚀</h3>
                                            <p style="margin: 5px 0 0; font-size: 14px; color: #6b7280;">Discover tools
                                                to supercharge your journey.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td style="padding: 0 10px; text-align: center;">
                                                        <a href="{{ route('scholarships.index') }}"
                                                            style="display: inline-block; text-decoration: none;">
                                                            <div
                                                                style="background: #white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 10px 15px; background-color: #ffffff;">
                                                                <span style="display: block; font-size: 20px;">🎓</span>
                                                                <span
                                                                    style="display: block; font-size: 12px; color: #374151; font-weight: 600; margin-top: 4px;">Scholarships</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td style="padding: 0 10px; text-align: center;">
                                                        <a href="{{ route('blog.index') }}"
                                                            style="display: inline-block; text-decoration: none;">
                                                            <div
                                                                style="background: #white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 10px 15px; background-color: #ffffff;">
                                                                <span style="display: block; font-size: 20px;">💡</span>
                                                                <span
                                                                    style="display: block; font-size: 12px; color: #374151; font-weight: 600; margin-top: 4px;">Expert
                                                                    Tips</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td style="padding: 0 10px; text-align: center;">
                                                        <a href="{{ route('resources.index') }}"
                                                            style="display: inline-block; text-decoration: none;">
                                                            <div
                                                                style="background: #white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 10px 15px; background-color: #ffffff;">
                                                                <span style="display: block; font-size: 20px;">🎒</span>
                                                                <span
                                                                    style="display: block; font-size: 12px; color: #374151; font-weight: 600; margin-top: 4px;">Resources</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- END MAIN CONTENT AREA -->
                    </table>

                    <!-- START FOOTER -->
                    <div class="footer" style="clear: both; margin-top: 20px; text-align: center; width: 100%;">
                        <table border="0" cellpadding="0" cellspacing="0"
                            style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                            <tr>
                                <td class="content-block"
                                    style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #9ca3af; text-align: center;">
                                    <span class="apple-link"
                                        style="color: #9ca3af; font-size: 12px; text-align: center;">Scholarpeep HQ •
                                        Your Gateway to Global Education</span>
                                    <br> Don't want these emails? <a href="{{ route('notifications.edit') }}"
                                        style="text-decoration: underline; color: #9ca3af; font-size: 12px; text-align: center;">Unsubscribe</a>.
                                </td>
                            </tr>
                            <tr>
                                <td class="content-block powered-by"
                                    style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #9ca3af; text-align: center;">
                                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- END FOOTER -->

                </div>
            </td>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        </tr>
    </table>
</body>

</html>