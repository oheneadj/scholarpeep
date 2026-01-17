@props(['posts'])

<div class="bg-white rounded-xl p-8 border border-gray-100 shadow-sm">
    <h3 class="font-bold text-gray-900 text-lg mb-6 flex items-center gap-2">
        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.285-2.652.004-.042.008-.083.013-.125.02-.193.04-.383.061-.571a.91.91 0 00-.365-.89.92.92 0 00-.916.035c-.31.196-.653.493-.956.883-.34.437-.665 1.05-.726 1.838-.057.733.076 1.636.566 2.527.276.502.66 1.002 1.134 1.439.424.39.927.7 1.48.868.513.156 1.05.156 1.574-.015.352-.115.68-.282.977-.493a10.02 10.02 0 013.921-1.071c1.348 0 2.61.326 3.738.9.897.456 1.59 1.157 2.012 2.003.352.706.518 1.488.47 2.278-.052.88-.344 1.693-.83 2.39-4.22 6.096-7.5-6.096-12.72-6.096z"
                clip-rule="evenodd" />
        </svg>
        Trending Now
    </h3>
    <div class="space-y-6">
        @foreach($posts as $index => $popular)
            <div class="flex gap-4 group">
                <span
                    class="text-3xl font-black text-blue-300 font-display group-hover:text-primary-100 transition-colors">0{{ $index + 1 }}</span>
                <div>
                    <h4 class="font-bold text-gray-900 leading-snug mb-1 group-hover:text-primary-600 transition-colors">
                        <a href="{{ route('blog.show', $popular->slug) }}">{{ $popular->title }}</a>
                    </h4>
                    <p class="text-[10px] uppercase font-bold text-gray-400">
                        {{ $popular->published_at->format('M j') }} •
                        {{ number_format($popular->views_count) }} views
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>