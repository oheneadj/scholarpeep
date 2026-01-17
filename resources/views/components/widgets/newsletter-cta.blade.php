@props([
    'title' => 'Subscribe to our Newsletter',
    'description' => 'Join the community of students receiving weekly scholarship alerts and study guides.',
    'placeholder' => 'Email address',
    'buttonText' => 'Subscribe',
    'theme' => 'primary'
])

@php
    $themes = [
        'primary' => [
            'bg' => 'bg-primary-50',
            'border' => 'border-primary-100',
            'buttonBg' => 'bg-primary-600',
            'buttonHover' => 'hover:bg-primary-700',
            'focusRing' => 'focus:ring-primary-500',
            'accentGradient' => 'from-primary-400 to-purple-400'
        ],
        'blue' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-100',
            'buttonBg' => 'bg-blue-600',
            'buttonHover' => 'hover:bg-blue-700',
            'focusRing' => 'focus:ring-blue-500',
            'accentGradient' => 'from-blue-400 to-indigo-400'
        ],
        'emerald' => [
            'bg' => 'bg-emerald-50',
            'border' => 'border-emerald-100',
            'buttonBg' => 'bg-emerald-600',
            'buttonHover' => 'hover:bg-emerald-700',
            'focusRing' => 'focus:ring-emerald-500',
            'accentGradient' => 'from-emerald-400 to-teal-400'
        ]
    ];
    
    $cfg = $themes[$theme] ?? $themes['primary'];
@endphp

<div class="relative mt-20 {{ $cfg['bg'] }} rounded-[2.5rem] p-10 md:p-16 text-center border {{ $cfg['border'] }} overflow-hidden group">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br {{ $cfg['accentGradient'] }} rounded-full filter blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-700"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr {{ $cfg['accentGradient'] }} rounded-full filter blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-700"></div>
    
    <!-- Icon -->
    <div class="relative z-10 inline-flex items-center justify-center w-16 h-16 rounded-2xl {{ $cfg['buttonBg'] }} text-white mb-6 shadow-xl shadow-{{ $theme }}-500/20 group-hover:scale-110 transition-transform duration-500">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </div>
    
    <!-- Content -->
    <div class="relative z-10">
        <h3 class="text-3xl md:text-4xl font-black font-display text-gray-900 mb-4 tracking-tight">{{ $title }}</h3>
        <p class="text-gray-600 max-w-lg mx-auto mb-10 text-base md:text-lg leading-relaxed">{{ $description }}</p>
        
        <!-- Form -->
        <form class="max-w-md mx-auto relative flex items-center group/form">
            <input 
                type="email" 
                placeholder="{{ $placeholder }}"
                required
                class="w-full pl-6 pr-36 py-4 md:py-5 rounded-full border-2 border-transparent shadow-xl {{ $cfg['focusRing'] }} focus:ring-2 focus:border-{{ $theme }}-200 text-gray-900 placeholder:text-gray-400 transition-all duration-300 group-hover/form:shadow-2xl"
            >
            <button
                type="submit"
                class="absolute right-1.5 top-1.5 bottom-1.5 px-6 md:px-8 rounded-full {{ $cfg['buttonBg'] }} text-white text-sm font-bold {{ $cfg['buttonHover'] }} transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 active:scale-95"
            >
                {{ $buttonText }}
            </button>
        </form>
        
        <!-- Trust Badge -->
        <p class="mt-6 text-xs text-gray-500 flex items-center justify-center gap-2">
            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium">No spam. Unsubscribe anytime.</span>
        </p>
    </div>
</div>
