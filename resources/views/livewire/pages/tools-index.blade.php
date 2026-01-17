<div class="bg-zinc-50 min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-white border-b border-gray-100 overflow-hidden">
        <div class="absolute inset-0 bg-blob-blue opacity-10 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black font-display text-gray-900 mb-6">
                Student <span class="text-primary-600">Tools</span>
            </h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">
                Essential utilities to help you succeed in your academic journey and scholarship applications.
            </p>
        </div>
    </div>

    <!-- Tools Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($tools as $tool)
                <div
                    class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div
                        class="w-14 h-14 rounded-xl bg-{{ $tool['color'] }}-50 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        @if($tool['icon'] === 'calculator')
                            <svg class="w-7 h-7 text-{{ $tool['color'] }}-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        @elseif($tool['icon'] === 'document-text')
                            <svg class="w-7 h-7 text-{{ $tool['color'] }}-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        @elseif($tool['icon'] === 'pencil')
                            <svg class="w-7 h-7 text-{{ $tool['color'] }}-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        @elseif($tool['icon'] === 'calendar')
                            <svg class="w-7 h-7 text-{{ $tool['color'] }}-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        @endif
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors">
                        {{ $tool['title'] }}
                    </h3>
                    <p class="text-gray-500 leading-relaxed mb-6">
                        {{ $tool['description'] }}
                    </p>

                    <a href="{{ $tool['link'] }}"
                        class="inline-flex items-center text-primary-600 font-bold text-sm hover:text-primary-700 transition-colors">
                        Use Tool
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>