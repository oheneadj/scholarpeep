@props(['title' => 'Featured'])

<div class="">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-900 font-display">{{ $title }}</h3>
        <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
    </div>
    <x-ad position="{{ \App\Enums\AdPosition::SIDEBAR }}" />
</div>