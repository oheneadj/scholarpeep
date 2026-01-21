@props(['theme' => 'auto', 'action' => 'login', 'tabindex' => 0])

@php
    $siteKey = app(\App\Settings\GeneralSettings::class)->turnstile_site_key;
@endphp

@if ($siteKey)
    @once
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endonce

    <div {{ $attributes->merge(['class' => 'cf-turnstile']) }} data-sitekey="{{ $siteKey }}" data-theme="{{ $theme }}"
        data-action="{{ $action }}" data-tabindex="{{ $tabindex }}">
    </div>

    @error('cf-turnstile-response')
        <p class="text-[10px] text-error-600 font-black uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
    @enderror
@endif