@props(['posts', 'title' => 'Stories That Matter'])

<div class="bg-white rounded-xl p-8 border border-gray-100 border-b-2 border-blue-500 shadow-gray-200/50 group/parent">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-bold text-gray-900 font-display flex items-center gap-2">
            {{ $title }}
        </h3>
        <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
    </div>

    <div class="space-y-6">
        @foreach($posts as $popular)
            <a href="{{ route('blog.show', $popular->slug) }}" class="group flex gap-4 items-start">
                <div
                    class="w-20 h-20 shrink-0 rounded-2xl bg-gray-50 overflow-hidden relative border border-gray-100 shadow-inner">
                    <img src="{{ Str::contains($popular->featured_image, 'http') ? $popular->featured_image : \Illuminate\Support\Facades\Storage::url($popular->featured_image) }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        alt="{{ $popular->title }}">
                </div>
                <div class="flex-1 min-w-0">
                    <h4
                        class="font-bold text-sm text-gray-900 leading-snug mb-1 group-hover:text-primary-600 transition-colors line-clamp-2">
                        {{ $popular->title }}
                    </h4>
                    <div class="flex items-center gap-2 text-[10px] font-extrabold text-gray-400 uppercase tracking-wide">
                        <span>{{ $popular->published_at->format('M j') }}</span>
                        @if($popular->views_count > 0)
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ number_format($popular->views_count) }}
                            </span>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>