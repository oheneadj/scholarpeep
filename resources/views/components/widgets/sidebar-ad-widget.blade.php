@props(['title' => 'Featured'])

<div class="">
    <div class="flex items-center justify-between mb-2">
        <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-[0.2em]">{{ $title }}</h3>
        <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
    </div>
    <x-ad position="{{ \App\Enums\AdPosition::SIDEBAR }}" />
</div>