<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@use('App\Settings\SeoSettings')
@php
    $seoSettings = app(SeoSettings::class);
    $defaultTitle = $seoSettings->site_name ?? config('app.name');
    $defaultDesc = $seoSettings->site_description;
    $defaultImage = $seoSettings->og_image ? Storage::url($seoSettings->og_image) : asset('img/og-image.png');
@endphp

<title>{{ $title ?? $defaultTitle }}</title>
<meta name="description" content="{{ $description ?? $defaultDesc }}">
<meta name="keywords" content="scholarships, education, global studies, funding, students">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:title" content="{{ $title ?? $defaultTitle }}">
<meta property="og:description" content="{{ $description ?? $defaultDesc }}">
<meta property="og:image" content="{{ $image ?? $defaultImage }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:site" content="{{ $seoSettings->twitter_handle }}">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $title ?? $defaultTitle }}">
<meta property="twitter:description" content="{{ $description ?? $defaultDesc }}">
<meta property="twitter:image" content="{{ $image ?? $defaultImage }}">

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:500,600,700,800" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

@include('partials.analytics')
@stack('schema')