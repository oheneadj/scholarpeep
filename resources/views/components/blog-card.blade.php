@props(['post'])

<article
    class="group bg-white rounded-xl p-4 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col md:flex-row gap-6 relative overflow-hidden">
    <!-- Image -->
    <div class="w-full md:w-64 h-48 rounded-xl overflow-hidden shrink-0 relative">
        <span
            class="absolute top-3 left-3 bg-white/90 backdrop-blur text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded text-primary-700 z-10">
            Article
        </span>
        <img src="{{ Str::startsWith($post->featured_image, 'http') ? $post->featured_image : \Illuminate\Support\Facades\Storage::url($post->featured_image) }}"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
    </div>

    <!-- Content -->
    <div class="flex-1 py-2 flex flex-col">
        <div class="flex items-center gap-3 mb-2">
            <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $post->published_at->format('M j, Y') }}
            </div>
            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
            <span class="text-[10px] font-bold uppercase tracking-widest text-primary-500">5 min
                read</span>
        </div>

        <h2
            class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors font-display leading-tight">
            <a href="{{ route('blog.show', $post->slug) }}"
                class="before:absolute before:inset-0">{{ $post->title }}</a>
        </h2>

        <p class="text-gray-500 text-sm leading-relaxed line-clamp-2 md:line-clamp-3 mb-4">
            {{ $post->excerpt }}
        </p>

        <div class="mt-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <img src="{{ $post->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}"
                    class="w-6 h-6 rounded-full">
                <span class="text-xs font-bold text-gray-700">{{ $post->author->name }}</span>
            </div>
            <span
                class="text-primary-600 hover:text-primary-700 text-sm font-bold group-hover:translate-x-1 transition-transform inline-flex items-center">
                Read more <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </div>
    </div>
</article>