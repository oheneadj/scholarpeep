@php
    $seoSettings = app(\App\Settings\SeoSettings::class);
@endphp

@if(app()->environment('production') || app()->environment('staging'))

    @if($seoSettings->google_analytics_id)
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seoSettings->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ $seoSettings->google_analytics_id }}');
        </script>
    @endif

    @if($seoSettings->plausible_domain)
        <!-- Plausible Analytics -->
        <script defer data-domain="{{ $seoSettings->plausible_domain }}" src="https://plausible.io/js/script.js"></script>
    @endif
    
@endif