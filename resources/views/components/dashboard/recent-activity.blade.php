@props(['recentActivity'])

{{-- Recent Activity Widget --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-200/50 relative mb-8 group/widget">
    {{-- Decorative Background Glow --}}
    <div
        class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary-50 rounded-full blur-[80px] opacity-40 group-hover/widget:opacity-60 transition-opacity duration-1000">
    </div>

    <div class="p-6 border-b border-gray-100 bg-gray-50/30 relative z-10 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">Recent Activity</h2>
            <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mt-0.5">Application Updates</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest">Live</span>
        </div>
    </div>

    <div class="p-6 relative z-10">
        @if(count($recentActivity) > 0)
            <div class="space-y-3">
                @foreach($recentActivity->take(6) as $activity)
                    @php
                        $isNew = $activity->updated_at->diffInHours() < 1;
                        $statusStyle = match ($activity->status->value) {
                            'saved' => [
                                'bg' => 'bg-gray-50',
                                'text' => 'text-gray-600',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />',
                                'border' => 'border-gray-100'
                            ],
                            'applied' => [
                                'bg' => 'bg-blue-50',
                                'text' => 'text-blue-600',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />',
                                'border' => 'border-blue-100'
                            ],
                            'accepted' => [
                                'bg' => 'bg-emerald-50',
                                'text' => 'text-emerald-600',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />',
                                'border' => 'border-emerald-100'
                            ],
                            'rejected' => [
                                'bg' => 'bg-rose-50',
                                'text' => 'text-rose-600',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />',
                                'border' => 'border-rose-100'
                            ],
                            'pending' => [
                                'bg' => 'bg-amber-50',
                                'text' => 'text-amber-600',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                'border' => 'border-amber-100'
                            ],
                            default => [
                                'bg' => 'bg-gray-50',
                                'text' => 'text-gray-500',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                'border' => 'border-gray-100'
                            ]
                        };
                    @endphp

                    <div
                        class="group relative flex items-center gap-4 p-3 rounded-2xl border {{ $statusStyle['border'] }} bg-white hover:border-primary-100 hover:shadow-sm transition-all duration-300">
                        {{-- Icon Column --}}
                        <div
                            class="relative shrink-0 w-10 h-10 rounded-xl {{ $statusStyle['bg'] }} {{ $statusStyle['text'] }} flex items-center justify-center transition-all group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $statusStyle['icon'] !!}
                            </svg>
                            @if($isNew)
                                <span
                                    class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-primary-500 border-2 border-white rounded-full"></span>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-4 mb-0.5">
                                <h4
                                    class="text-sm font-bold text-gray-900 truncate group-hover:text-primary-600 transition-colors tracking-tight">
                                    {{ $activity->scholarship->title }}
                                </h4>
                                <span class="shrink-0 text-[10px] font-medium text-gray-400">
                                    {{ $activity->updated_at->diffForHumans() }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="px-2 py-0.5 rounded-full {{ $statusStyle['bg'] }} {{ $statusStyle['text'] }} text-[8px] font-bold uppercase tracking-wider">
                                    {{ $activity->status->label() }}
                                </span>
                            </div>
                        </div>

                        {{-- Action Arrow --}}
                        <a href="{{ route('scholarships.show', $activity->scholarship->slug) }}"
                            class="p-2 text-gray-300 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all transform group-hover:translate-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 text-center pt-4 border-t border-gray-50">
                <a href="{{ route('my-applications') }}"
                    class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-primary-600 transition-colors">
                    View Full History
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        @else
            <div class="py-12 text-center border-2 border-dashed border-gray-100 rounded-2xl bg-gray-50/50">
                <div
                    class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-gray-200 mx-auto mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900 mb-1">No Activity Yet</h3>
                <p class="text-xs text-gray-500">Your application updates will appear here.</p>
            </div>
        @endif
    </div>
</div>