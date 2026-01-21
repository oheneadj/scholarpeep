@props([
'sidebar' => false,
])

@php
    $seoSettings = app(\App\Settings\SeoSettings::class);
    $siteLogo = $seoSettings->site_logo 
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($seoSettings->site_logo) 
        : null;
    $siteName = $seoSettings->site_name ?? 'Scholarpeep';
@endphp

@if($sidebar)
    <flux:sidebar.brand :name="$siteName" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            @if($siteLogo)
                <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="size-8 object-contain rounded-md" />
            @else
                <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
            @endif
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="$siteName" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            @if($siteLogo)
                <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="size-8 object-contain rounded-md" />
            @else
                <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
            @endif
        </x-slot>
    </flux:brand>
@endif
