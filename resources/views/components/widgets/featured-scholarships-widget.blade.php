@props(['scholarships', 'title' => 'Featured Discovery'])

<div class="space-y-6">
    <h3 class="text-xl font-bold font-display text-gray-950 px-2">{{ $title }}</h3>
    <div class="space-y-4">
        @foreach($scholarships as $featured)
            <a href="{{ route('scholarships.show', $featured->slug) }}"
                class="group block p-5 bg-white border-2 border-blue-200 rounded-3xl shadow-gray-200/50 hover:shadow-xl hover:shadow-primary-900/5 hover:-translate-y-1 transition-all duration-300">
                <div class="flex gap-5 items-center">
                    <div
                        class="w-14 h-14 rounded-2xl overflow-hidden shrink-0 shadow-inner border border-gray-50 group-hover:scale-110 transition-transform">
                        <img src="{{ $featured->provider_logo ?? 'https://ui-avatars.com/api/?name=' . urlencode($featured->provider_name) }}"
                            class="w-full h-full object-cover" alt="{{ $featured->provider_name }}">
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span
                                class="px-2 py-0.5 bg-primary-50 text-primary-600 text-[8px] font-black uppercase tracking-wider rounded-md border border-primary-100/50">Featured</span>
                        </div>
                        <h4
                            class="text-sm font-bold text-gray-900 line-clamp-2 leading-relaxed group-hover:text-primary-700 transition-colors">
                            {{ $featured->title }}
                        </h4>
                    </div>
                    <div
                        class="shrink-0 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.1"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>