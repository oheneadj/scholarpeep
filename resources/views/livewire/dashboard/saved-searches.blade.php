<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight font-display">Saved Searches</h2>
            <p class="text-sm text-gray-500 font-medium">Quickly access scholarships matching your specific criteria.
            </p>
        </div>
    </div>

    @if($searches->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-200/50">
            <div class="mx-auto h-20 w-20 text-primary-100 mb-6">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 mb-2 font-display">Start Your Search</h3>
            <p class="text-gray-500 max-w-sm mx-auto mb-8 font-medium">You haven't saved any
                searches yet. Save your favorite filters to stay updated on new opportunities.</p>
            <a href="{{ route('scholarships.index') }}"
                class="inline-flex items-center px-8 py-4 bg-primary-600 text-white rounded-full font-black text-sm hover:bg-primary-700 transition-all shadow-xl shadow-primary-600/10 active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Find Scholarships
            </a>
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($searches as $search)
                <div
                    class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all p-6 relative group overflow-hidden">
                    <div
                        class="absolute top-0 left-0 w-1 h-full bg-primary-500 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>

                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <button wire:click="delete({{ $search->id }})"
                            wire:confirm="Are you sure you want to delete this saved search?"
                            class="p-2 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-100 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <a href="{{ $search->url }}" class="block">
                        <div class="mb-4">
                            <h3
                                class="font-black text-gray-900 text-lg leading-tight pr-8 mb-1 group-hover:text-primary-600 transition-colors font-display">
                                {{ $search->name }}
                            </h3>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Created {{ $search->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($search->filters as $key => $value)
                                @if(!empty($value) && $key !== 'page')
                                    @php
                                        $svg = match ($key) {
                                            'country' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                            'education_level', 'level' => '<path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />',
                                            'field_of_study', 'field' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />',
                                            'scholarship_type', 'type' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />',
                                            'award_amount', 'amount' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                            default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />'
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-gray-50 text-gray-600 border border-gray-100 group-hover:bg-primary-50 group-hover:text-primary-700 group-hover:border-primary-100 transition-colors shrink-0">
                                        <svg class="w-3 h-3 mr-1.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $svg !!}
                                        </svg>
                                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                                    </span>
                                @endif
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                            <span class="text-xs font-bold text-primary-600 flex items-center gap-1">
                                View Results
                                <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>