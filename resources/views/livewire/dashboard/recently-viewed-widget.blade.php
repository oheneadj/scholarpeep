<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-gray-50 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Recently Viewed</h3>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Your scholarship history</p>
            </div>
        </div>
    </div>

    <div class="p-6">
        @if($scholarships->count() > 0)
            <div class="space-y-4">
                @foreach($scholarships as $scholarship)
                    <a href="{{ route('scholarships.show', $scholarship->slug) }}"
                        class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition-all border border-transparent hover:border-gray-100 group">
                        <div
                            class="w-12 h-12 rounded-lg overflow-hidden shrink-0 bg-gray-50 flex items-center justify-center border border-gray-100 shadow-sm">
                            <img src="{{ $scholarship->provider_logo ?? 'https://ui-avatars.com/api/?name=' . urlencode($scholarship->provider_name) }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-gray-900 truncate group-hover:text-primary-600 transition-colors">
                                {{ $scholarship->title }}
                            </h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span
                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $scholarship->provider_name }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-200"></span>
                                <span class="text-[10px] font-extrabold text-primary-600 uppercase tracking-widest">
                                    {{ $scholarship->currency }} {{ number_format($scholarship->award_amount) }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-10">
                <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <h4 class="text-xs font-bold text-gray-900 mb-1">No history yet</h4>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Start exploring scholarships</p>
                <a href="{{ route('scholarships.index') }}"
                    class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 text-white text-[10px] font-bold uppercase tracking-widest rounded-full hover:bg-primary-700 transition shadow-lg shadow-primary-200">
                    Browse Now
                </a>
            </div>
        @endif
    </div>
</div>