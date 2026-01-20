@props(['label', 'value', 'subtext' => null, 'color' => 'primary'])

@php
    $themes = [
        'primary' => [
            'border' => 'hover:border-primary-100',
            'icon_bg' => 'bg-primary-600',
            'icon_text' => 'text-white',
            'hover_icon_bg' => 'group-hover:bg-primary-600',
            'hover_icon_text' => 'group-hover:text-white',
            'label_hover' => 'group-hover:text-primary-600',
        ],
        'blue' => [
            'border' => 'hover:border-blue-100',
            'icon_bg' => 'bg-blue-600',
            'icon_text' => 'text-white',
            'hover_icon_bg' => 'group-hover:bg-blue-600',
            'hover_icon_text' => 'group-hover:text-white',
            'label_hover' => 'group-hover:text-blue-600',
        ],
        'orange' => [
            'border' => 'hover:border-orange-100',
            'icon_bg' => 'bg-orange-600',
            'icon_text' => 'text-white',
            'hover_icon_bg' => 'group-hover:bg-orange-600',
            'hover_icon_text' => 'group-hover:text-white',
            'label_hover' => 'group-hover:text-orange-600',
        ],
        'warning' => [
            'border' => 'hover:border-amber-100',
            'icon_bg' => 'bg-amber-600',
            'icon_text' => 'text-white',
            'hover_icon_bg' => 'group-hover:bg-amber-600',
            'hover_icon_text' => 'group-hover:text-white',
            'label_hover' => 'group-hover:text-amber-600',
        ],
        'rose' => [
            'border' => 'hover:border-rose-100',
            'icon_bg' => 'bg-rose-600',
            'icon_text' => 'text-white',
            'hover_icon_bg' => 'group-hover:bg-rose-600',
            'hover_icon_text' => 'group-hover:text-white',
            'label_hover' => 'group-hover:text-rose-600',
        ],
        'emerald' => [
            'border' => 'hover:border-emerald-100',
            'icon_bg' => 'bg-emerald-600',
            'icon_text' => 'text-white',
            'hover_icon_bg' => 'group-hover:bg-emerald-600',
            'hover_icon_text' => 'group-hover:text-white',
            'label_hover' => 'group-hover:text-emerald-600',
        ],
        'emerald-dark' => [
            'border' => 'hover:border-emerald-100',
            'icon_bg' => 'bg-emerald-900',
            'icon_text' => 'text-white',
            'hover_icon_bg' => 'group-hover:bg-emerald-800',
            'hover_icon_text' => 'group-hover:text-white',
            'label_hover' => 'group-hover:text-emerald-600',
        ],
    ];

    $theme = $themes[$color] ?? $themes['primary'];
@endphp

<div
    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-200/50 group {{ $theme['border'] }} transition-all duration-300">
    <div class="flex items-center justify-between mb-4">
        <div
            class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-500 {{ $theme['icon_bg'] }} {{ $theme['icon_text'] }} {{ $theme['hover_icon_bg'] }} {{ $theme['hover_icon_text'] }}">
            {{ $icon }}
        </div>
        <span
            class="text-[10px] font-bold text-gray-500 uppercase tracking-widest transition-colors {{ $theme['label_hover'] }}">
            {{ $label }}
        </span>
    </div>
    <div class="flex items-baseline gap-2">
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            <span class="text-2xl font-bold text-gray-900 tracking-tight">{{ $value }}</span>
        @endif

        @if($subtext)
            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $subtext }}</span>
        @endif
    </div>
</div>