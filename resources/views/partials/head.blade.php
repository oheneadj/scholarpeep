<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>
<meta name="description"
    content="{{ $description ?? 'Scholarpeep - Your gateway to global scholarship opportunities and education resources.' }}">
<meta name="keywords" content="scholarships, education, global studies, funding, students">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title ?? config('app.name') }}">
<meta property="og:description"
    content="{{ $description ?? 'Scholarpeep - Your gateway to global scholarship opportunities and education resources.' }}">
<meta property="og:image" content="{{ asset('img/og-image.png') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $title ?? config('app.name') }}">
<meta property="twitter:description"
    content="{{ $description ?? 'Scholarpeep - Your gateway to global scholarship opportunities and education resources.' }}">
<meta property="twitter:image" content="{{ asset('img/og-image.png') }}">

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:500,600,700,800" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance