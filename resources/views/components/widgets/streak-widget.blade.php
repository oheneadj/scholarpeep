@props(['streak' => 0, 'nextMilestone' => 7, 'daysLeft' => 7])

@php
    $percentage = min(100, ($streak / $nextMilestone) * 100);
    $milestonePoints = match ($nextMilestone) {
        7 => 100,
        14 => 200,
        30 => 500,
        60 => 1000,
        100 => 2500,
        default => 500
    };
@endphp

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-200/50 group/streak relative">
    {{-- Background Decorative Glow --}}
    <div
        class="absolute -top-12 -left-12 w-32 h-32 bg-orange-50 rounded-full blur-[40px] opacity-60 group-hover/streak:opacity-80 transition-opacity duration-700">
    </div>

    <div class="p-5 relative z-10">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div
                    class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 border border-orange-100 group-hover/streak:scale-110 transition-transform duration-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.99 7.99 0 0120 13a7.98 7.98 0 01-2.343 5.657z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.879 16.121A3 3 0 1012.015 11L11 14l-1.121 2.121z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-orange-600 uppercase tracking-widest leading-none mb-1">Login
                        Streak</p>
                    <h4 class="text-sm font-bold text-gray-900 leading-none">Stay Consistent</h4>
                </div>
            </div>
            <div
                class="bg-orange-600 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg shadow-orange-200 animate-pulse">
                {{ $streak }} Days
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex items-center justify-between text-[11px]">
                <span class="font-bold text-gray-500 uppercase tracking-wider">Next Reward: <span
                        class="text-orange-600">+{{ $milestonePoints }} PTS</span></span>
                <span class="font-bold text-gray-900">{{ $daysLeft }} days to go</span>
            </div>

            <div class="relative h-2.5 w-full bg-gray-100 rounded-full overflow-hidden shadow-inner">
                {{-- Progress Bar --}}
                <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-orange-400 to-orange-600 rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-1"
                    style="width: {{ $percentage }}%">
                    <div class="w-1 h-1 bg-white rounded-full opacity-50"></div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-1">
                <span class="text-[9px] font-bold text-gray-400">Day 0</span>
                <div class="flex items-center gap-1 bg-orange-50 px-2 py-0.5 rounded-lg border border-orange-100">
                    <svg class="w-2.5 h-2.5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-[10px] font-bold text-orange-600">Day {{ $nextMilestone }}</span>
                </div>
            </div>
        </div>
    </div>
</div>