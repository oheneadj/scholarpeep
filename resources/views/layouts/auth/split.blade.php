<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased">
    <div
        class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
        <div class="relative hidden h-full flex-col p-12 text-white lg:flex bg-primary-950">
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-primary-600/20 via-transparent to-transparent">
            </div>

            <a href="{{ route('home') }}" class="relative z-20 flex items-center gap-2 group" wire:navigate>
                <div
                    class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center group-hover:bg-primary-500 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <span class="text-2xl font-bold font-outfit tracking-tight">Scholarpeep</span>
            </a>

            @php
                [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
            @endphp

            <div class="relative z-20 mt-auto">
                <blockquote class="space-y-4">
                    <p class="text-3xl font-bold font-display leading-tight">&ldquo;{{ trim($message) }}&rdquo;</p>
                    <footer class="text-primary-400 font-bold uppercase tracking-widest text-xs">— {{ trim($author) }}
                    </footer>
                </blockquote>
            </div>
        </div>
        <div class="w-full lg:p-12">
            <div class="mx-auto flex w-full flex-col justify-center space-y-8 sm:w-[400px]">
                <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-3 lg:hidden" wire:navigate>
                    <div class="w-12 h-12 bg-primary-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold font-outfit text-gray-900 tracking-tight">Scholarpeep</span>
                </a>
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>