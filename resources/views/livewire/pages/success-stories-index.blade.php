<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-16">
            <h1 class="text-5xl font-black text-gray-900 tracking-tight mb-4">Inspirational <span
                    class="text-primary-600">Journeys</span></h1>
            <p class="text-xl text-gray-500 font-medium max-w-2xl mx-auto">Discover how students from around the world
                achieved their dreams through ScholarPeep.</p>
        </div>

        {{-- Stories Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($stories as $story)
                <div
                    class="bg-white rounded-2xl shadow-200/50 border border-gray-100 overflow-hidden group hover:border-primary-100 transition-all duration-300">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ $story->photo_url }}" alt="{{ $story->student_name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="px-3 py-1 bg-primary-50 text-primary-600 rounded-lg text-[10px] font-bold uppercase tracking-widest">
                                {{ $story->country ?? 'Global' }}
                            </span>
                            @if($story->university)
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    {{ $story->university }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 leading-snug">{{ $story->title }}</h3>
                        <p class="text-gray-500 font-medium line-clamp-3 mb-6 leading-relaxed">
                            {{ Str::limit($story->story, 150) }}
                        </p>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 font-bold text-xs ring-2 ring-white">
                                    {{ strtoupper(substr($story->student_name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $story->student_name }}</span>
                            </div>
                            <button
                                class="text-primary-600 font-bold text-xs uppercase tracking-widest hover:text-primary-700 transition-colors">
                                Read Story
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div
                        class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v12a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No success stories yet</h3>
                    <p class="text-gray-500 font-medium">Be the first to share your journey!</p>
                    <a href="{{ route('dashboard.success-stories.submit') }}"
                        class="inline-flex mt-6 px-8 py-4 bg-primary-600 text-white rounded-full font-bold uppercase tracking-widest hover:bg-primary-700 shadow-lg shadow-primary-200 transition-all active:scale-95">
                        Share My Story
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-16">
            {{ $stories->links() }}
        </div>
    </div>
</div>