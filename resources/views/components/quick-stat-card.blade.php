@props([
    'theme' => 'primary',
    'label' => '',
    'value' => '',
    'icon' => null,
])

@php
    $themes = [
        'emerald' => [
            'bg' => 'bg-emerald-50/50',
            'border' => 'border-emerald-100/50',
            'iconBg' => 'bg-emerald-500',
            'labelColor' => 'text-emerald-600',
            'hoverShadow' => 'hover:shadow-emerald-900/5',
            'hoverValue' => 'group-hover:text-emerald-700',
            'iconShadow' => 'shadow-emerald-500/20'
        ],
        'blue' => [
            'bg' => 'bg-blue-50/50',
            'border' => 'border-blue-100/50',
            'iconBg' => 'bg-blue-500',
            'labelColor' => 'text-blue-600',
            'hoverShadow' => 'hover:shadow-blue-900/5',
            'hoverValue' => 'group-hover:text-blue-700',
            'iconShadow' => 'shadow-blue-500/20'
        ],
        'indigo' => [
            'bg' => 'bg-indigo-50/50',
            'border' => 'border-indigo-100/50',
            'iconBg' => 'bg-indigo-500',
            'labelColor' => 'text-indigo-600',
            'hoverShadow' => 'hover:shadow-indigo-900/5',
            'hoverValue' => 'group-hover:text-indigo-700',
            'iconShadow' => 'shadow-indigo-500/20'
        ],
        'amber' => [
            'bg' => 'bg-amber-50/50',
            'border' => 'border-amber-100/50',
            'iconBg' => 'bg-amber-500',
            'labelColor' => 'text-amber-600',
            'hoverShadow' => 'hover:shadow-amber-900/5',
            'hoverValue' => 'group-hover:text-amber-700',
            'iconShadow' => 'shadow-amber-500/20'
        ],
        'primary' => [
            'bg' => 'bg-primary-50/50',
            'border' => 'border-primary-100/50',
            'iconBg' => 'bg-primary-600',
            'labelColor' => 'text-primary-600',
            'hoverShadow' => 'hover:shadow-primary-900/5',
            'hoverValue' => 'group-hover:text-primary-700',
            'iconShadow' => 'shadow-primary-500/20'
        ]
    ];

    $cfg = $themes[$theme] ?? $themes['primary'];
@endphp

<div {{ $attributes->merge(['class' => "group p-6 {$cfg['bg']} rounded-[1.5rem] border {$cfg['border']} shadow-sm hover:shadow-xl {$cfg['hoverShadow']} hover:-translate-y-1 transition-all duration-500"]) }}>
    <div class="w-10 h-10 rounded-xl {$cfg['iconBg']} text-primary flex items-center justify-center mb-4 shadow-lg {$cfg['iconShadow']} group-hover:scale-110 transition-transform">
        @if($icon)
            {{ $icon }}
        @else
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @endif
    </div>
    <p class="text-[9px] font-extrabold {$cfg['labelColor']} uppercase tracking-widest mb-1">{{ $label }}</p>
    <div class="text-md font-bold text-gray-900 font-display transition-colors {$cfg['hoverValue']} truncate">
        {{ $value }}
    </div>
</div>
