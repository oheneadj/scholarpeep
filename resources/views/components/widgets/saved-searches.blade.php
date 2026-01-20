@props(['searches' => []])

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-200/50 group/searches relative">
    {{-- Background Decorative Glow --}}
    <div
        class="absolute -top-12 -right-12 w-32 h-32 bg-blue-50 rounded-full blur-[40px] opacity-60 group-hover/searches:opacity-80 transition-opacity duration-700">
    </div>

    <div class="p-5 relative z-10">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div
                    class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 group-hover/searches:scale-110 transition-transform duration-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 leading-none mb-1">Saved Searches</h4>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">Quick
                        Discovery</p>
                </div>
            </div>
            @if(count($searches) > 0)
                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                    {{ count($searches) }} Total
                </span>
            @endif
        </div>

        @if(count($searches) > 0)
            <div class="space-y-2">
                @foreach($searches as $search)
                    <div
                        class="bg-gray-50/50 hover:bg-gray-50 border border-transparent hover:border-blue-100 rounded-xl p-3 flex items-center justify-between group/item transition-all duration-300">
                        <a href="{{ $search->url }}" class="flex-1">
                            <h5 class="text-xs font-bold text-gray-900 group-hover/item:text-blue-600 transition-colors">
                                {{ $search->name }}</h5>
                            <div class="flex gap-2 mt-1">
                                @if(isset($search->filters['q']) && $search->filters['q'])
                                    <span class="text-[9px] font-medium text-gray-400">"{{ $search->filters['q'] }}"</span>
                                @endif
                                @if(isset($search->filters['country']) && count($search->filters['country']) > 0)
                                    <span class="text-[9px] font-medium text-gray-400">{{ count($search->filters['country']) }}
                                        Locations</span>
                                @endif
                            </div>
                        </a>
                        <button wire:click="deleteSavedSearch({{ $search->id }})"
                            wire:confirm="Are you sure you want to delete this saved search?"
                            class="p-1.5 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all opacity-0 group-hover/item:opacity-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6">
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <p class="text-xs font-semibold text-gray-500 mb-1">No saved searches yet</p>
                <p class="text-[10px] text-gray-400">Save a search on the discovery page to see it here.</p>
                <a href="{{ route('scholarships.index') }}"
                    class="inline-block mt-4 text-[10px] font-bold text-blue-600 hover:text-blue-700 uppercase tracking-widest border-b border-blue-200">Start
                    Searching</a>
            </div>
        @endif
    </div>
</div>