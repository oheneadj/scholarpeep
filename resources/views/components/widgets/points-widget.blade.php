<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-200/50 group/points">
    {{-- Header with Gradient --}}
    <div class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-purple-700 p-6 overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>

        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-[10px] font-bold text-primary-200 uppercase tracking-widest mb-1 opacity-80">Rank</p>
                    <h3 class="text-xl font-bold text-white tracking-tight">Level {{ $summary['current_level'] }}</h3>
                </div>
                <div
                    class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/10 group-hover/points:scale-110 transition-transform duration-500">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
            </div>

            {{-- Points Display --}}
            <div class="flex items-baseline gap-1.5 mb-0.5">
                <span
                    class="text-4xl font-bold text-white tracking-tight">{{ number_format($summary['total_points']) }}</span>
                <span class="text-sm font-bold text-primary-200 opacity-80 uppercase tracking-wider">points</span>
            </div>
            <p class="text-xs text-primary-200 font-medium opacity-70">
                {{ number_format($summary['lifetime_points']) }} earned all-time
            </p>
        </div>
    </div>

    {{-- Progress Section --}}
    <div class="p-5 bg-gray-50/50">
        <div class="flex items-center justify-between text-[11px] mb-3">
            <span class="font-bold text-gray-500 uppercase tracking-wider">Next Level</span>
            <span class="font-bold text-gray-900">{{ number_format($summary['points_to_next_level']) }} pts to go</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden shadow-inner">
            <div class="bg-gradient-to-r from-primary-600 to-purple-600 h-full rounded-full transition-all duration-1000 ease-out"
                style="width: {{ $summary['progress_percentage'] }}%">
            </div>
        </div>
    </div>
</div>