@props(['badges' => [], 'limit' => 6])

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-200/50 relative group/widget">
    {{-- Background Decorative Elements --}}
    <div
        class="absolute -top-24 -right-24 w-64 h-64 bg-primary-50 rounded-full blur-[80px] opacity-40 group-hover/widget:opacity-60 transition-opacity duration-1000">
    </div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full opacity-[0.03] pointer-events-none"
        style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>

    <div class="p-6 border-b border-gray-100 bg-gray-50/20 relative z-10 backdrop-blur-sm">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Achievements</p>
                </div>
                <h3 class="text-xl font-bold text-gray-900 leading-tight">Recent Badges</h3>
            </div>
            <a href="#"
                class="group/btn relative px-4 py-2 bg-primary-600 rounded-full overflow-hidden transition-all duration-300 hover:bg-primary-700 hover:scale-105 active:scale-95 shadow-sm">
                <span class="relative z-10 text-xs font-semibold text-white flex items-center gap-2">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </span>
            </a>
        </div>
    </div>

    <div class="p-6 relative z-10">
        @if ($badges->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                @foreach ($badges->take($limit) as $badge)
                    @php
                        $earnedAt = \Carbon\Carbon::parse($badge->pivot->earned_at);
                        $isNewest = $loop->first && $earnedAt->diffInHours() < 24;
                        $tierStyles = [
                            'bronze' => [
                                'gradient' => 'from-orange-400 via-orange-500 to-amber-700',
                                'glow' => 'shadow-orange-200/50',
                                'text' => 'text-orange-100',
                                'label' => 'bg-amber-900/20 text-amber-100'
                            ],
                            'silver' => [
                                'gradient' => 'from-slate-300 via-slate-400 to-slate-600',
                                'glow' => 'shadow-slate-200/50',
                                'text' => 'text-slate-100',
                                'label' => 'bg-slate-900/20 text-slate-100'
                            ],
                            'gold' => [
                                'gradient' => 'from-yellow-300 via-yellow-500 to-amber-600',
                                'glow' => 'shadow-yellow-200/50',
                                'text' => 'text-yellow-100',
                                'label' => 'bg-yellow-900/20 text-yellow-100'
                            ],
                            'platinum' => [
                                'gradient' => 'from-indigo-400 via-purple-500 to-fuchsia-700',
                                'glow' => 'shadow-indigo-200/50',
                                'text' => 'text-indigo-100',
                                'label' => 'bg-indigo-900/20 text-indigo-100'
                            ],
                        ];
                        $style = $tierStyles[$badge->tier] ?? $tierStyles['silver'];
                    @endphp

                    <div class="group relative" x-data="{ show: false }">
                        <div @mouseenter="show = true" @mouseleave="show = false"
                            class="relative aspect-square bg-gradient-to-br {{ $style['gradient'] }} rounded-2xl p-4 text-white text-center transition-all duration-500 hover:scale-110 hover:-translate-y-1 {{ $style['glow'] }} hover:shadow-lg cursor-pointer overflow-hidden border border-white/20">

                            {{-- Glass Reflection --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/20 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>

                            {{-- Animated Shine --}}
                            <div
                                class="absolute inset-0 w-full h-full bg-gradient-to-tr from-white/0 via-white/40 to-white/0 -translate-x-full group-hover:animate-shine pointer-events-none">
                            </div>

                            <div class="relative z-10 flex flex-col items-center justify-center h-full">
                                <div
                                    class="text-4xl sm:text-5xl mb-2 filter drop-shadow-lg group-hover:scale-125 transition-all duration-500 ease-out">
                                    {{ $badge->icon }}
                                </div>
                                <div
                                    class="px-2 py-0.5 rounded-full {{ $style['label'] }} backdrop-blur-sm border border-white/10">
                                    <p class="text-[10px] font-bold uppercase tracking-wider">
                                        {{ $badge->tier }}
                                    </p>
                                </div>
                            </div>

                            @if($isNewest)
                                <div class="absolute top-2 right-2">
                                    <span class="relative flex h-2 w-2">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Premium Tooltip --}}
                        <div x-show="show" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-4 w-52 bg-gray-900/95 backdrop-blur-xl text-white p-4 rounded-xl shadow-xl pointer-events-none z-[100] border border-white/10">

                            <div class="text-center">
                                <div class="text-[10px] font-semibold text-primary-400 uppercase tracking-wider mb-1">
                                    {{ $badge->tier }} Achievement
                                </div>
                                <div class="font-bold text-sm mb-1">{{ $badge->name }}</div>
                                <div class="text-gray-400 text-xs font-medium leading-normal mb-3">
                                    {{ $badge->description }}
                                </div>

                                <div class="pt-3 border-t border-white/5 flex items-center justify-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-500 text-[10px] font-semibold uppercase tracking-wider">
                                        {{ $earnedAt->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            {{-- Tooltip Arrow --}}
                            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1">
                                <div class="border-8 border-transparent border-t-gray-900/95"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 px-6 border-2 border-dashed border-gray-100 rounded-2xl bg-gray-50/50">
                <div class="relative inline-flex mb-6">
                    <div
                        class="w-16 h-16 bg-white rounded-xl items-center justify-center flex border border-gray-100 shadow-sm relative z-10">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2">Unlock Your Journey</h4>
                <p class="text-sm text-gray-500 font-medium max-w-[200px] mx-auto leading-normal mb-6">
                    Earn badges by completing tasks and saving scholarships.
                </p>
                <a href="{{ route('scholarships.index') }}"
                    class="text-xs font-bold text-primary-600 uppercase tracking-widest hover:text-primary-700 flex items-center justify-center gap-2 group/link">
                    Explore Now
                    <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes shine {
        0% {
            transform: translateX(-100%) rotate(45deg);
        }

        100% {
            transform: translateX(200%) rotate(45deg);
        }
    }

    .animate-shine {
        animation: shine 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }
</style>