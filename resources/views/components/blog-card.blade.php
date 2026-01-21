@props(['post'])

<article
    class="group bg-white rounded-2xl p-4 shadow-200/50 hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col md:flex-row gap-6 relative overflow-hidden">
    <!-- Image -->
    <div
        class="w-full md:w-64 h-48 rounded-2xl overflow-hidden shrink-0 relative flex items-center justify-center bg-gray-50 border border-gray-100">
        <span
            class="absolute top-3 left-3 bg-white/90 backdrop-blur text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded-lg text-primary-700 z-10 border border-gray-100 shadow-sm">
            Article
        </span>
        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }} Featured Image"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
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
            <span class="w-1 h-1 rounded-full bg-gray-200"></span>
            <span class="text-[10px] font-bold uppercase tracking-widest text-primary-500">5 min read</span>
        </div>

        <h2
            class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors leading-snug tracking-tight">
            <a href="{{ route('blog.show', $post->slug) }}"
                class="before:absolute before:inset-0">{{ $post->title }}</a>
        </h2>

        <p class="text-gray-500 text-sm font-medium leading-relaxed line-clamp-2 md:line-clamp-3 mb-4">
            {{ $post->excerpt }}
        </p>

        <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50">
            <div class="flex items-center gap-2">
                <img src="{{ $post->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}"
                    alt="{{ $post->author->name }}" class="w-6 h-6 rounded-full ring-2 ring-gray-100" loading="lazy">
                <span class="text-xs font-bold text-gray-700">{{ $post->author->name }}</span>
            </div>
            <a href="{{ route('blog.show', $post->slug) }}"
                class="inline-flex items-center gap-1 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-[10px] font-bold uppercase tracking-wider rounded-full transition-all transform hover:scale-105 shadow-sm hover:shadow-md relative z-20">
                Read more <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</article>