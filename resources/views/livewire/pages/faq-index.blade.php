<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gray-900 border-b border-gray-800 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-800 to-purple-900 opacity-90"></div>
        <div class="absolute inset-0 bg-blob-grid opacity-20 pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-black font-display text-white mb-6">
                How can we <span class="text-primary-400">help?</span>
            </h1>
            <p class="text-xl text-primary-100 mb-12 leading-relaxed font-light">
                Find answers to common questions about scholarships, applications, and managing your account.
            </p>

            <!-- Search Bar -->
            <div class="relative max-w-2xl mx-auto group">
                <div
                    class="relative bg-white/10 backdrop-blur-md rounded-2xl shadow-xl flex items-center p-2 border border-white/20 focus-within:border-primary-400 focus-within:bg-white/20 transition-all duration-300">
                    <svg class="w-6 h-6 text-primary-200 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Search for answers (e.g. 'deadlines', 'password')"
                        class="w-full border-none focus:ring-0 bg-transparent text-white placeholder-primary-200 text-lg py-3 px-4 rounded-xl">
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Content -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        @if($search)
            <!-- Search Results -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Search Results</h2>
                @if($faqs->isEmpty())
                    <div class="text-center py-12 bg-white rounded-2xl border border-gray-100 border-dashed">
                        <p class="text-gray-500">No results found for "{{ $search }}".</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($faqs as $faq)
                            <x-faq-item :faq="$faq" />
                        @endforeach
                    </div>
                @endif
            </div>
        @elseif($groupedFaqs)
            <!-- Grouped Categories -->
            <div class="space-y-12">
                @foreach($groupedFaqs as $category => $categoryFaqs)
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <span
                                class="w-8 h-8 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center text-sm font-black">
                                {{ substr($category ?? 'O', 0, 1) }}
                            </span>
                            {{ $category ?? 'Other Questions' }}
                        </h2>
                        <div class="space-y-4">
                            @foreach($categoryFaqs as $faq)
                                <x-faq-item :faq="$faq" />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Contact Support -->
        <div class="mt-20 text-center">
            <p class="text-gray-500 mb-4">Can't find what you're looking for?</p>
            <a href="#"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white border border-gray-200 text-gray-700 font-bold hover:border-primary-600 hover:text-primary-600 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Contact Support
            </a>
        </div>
    </div>
</div>