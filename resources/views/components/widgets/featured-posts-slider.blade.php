@props(['posts'])

@if($posts->count() > 0)
    <div class="bg-primary-900 rounded-xl overflow-hidden relative group" x-data="{ 
                activeSlide: 0, 
                slides: {{ $posts->count() }},
                timer: null,
                next() { this.activeSlide = (this.activeSlide + 1) % this.slides },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides },
                startTimer() { this.timer = setInterval(() => this.next(), 5000) },
                stopTimer() { clearInterval(this.timer) }
             }" x-init="startTimer()" @mouseenter="stopTimer()" @mouseleave="startTimer()">

        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent z-10"></div>

        <div class="relative h-[400px]">
            @foreach($posts as $index => $post)
                <div x-show="activeSlide === {{ $index }}" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-300 absolute top-0 left-0 w-full"
                    x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-12"
                    class="absolute inset-0 w-full h-full">

                    <img src="{{ $post->image_url ?? 'https://placehold.co/600x800' }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover">

                    <div class="absolute bottom-0 left-0 w-full p-6 z-20">
                        @if($post->category)
                            <span
                                class="inline-block px-2 py-1 rounded bg-white/20 backdrop-blur-sm text-xs font-bold text-white mb-3">
                                {{ $post->category->name }}
                            </span>
                        @endif

                        <h4 class="text-xl font-bold text-white leading-tight mb-2 font-display">
                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary-300 transition-colors">
                                {{ $post->title }}
                            </a>
                        </h4>

                        <div class="flex items-center text-gray-300 text-xs gap-3">
                            <span class="font-bold text-white">{{ $post->author->name ?? 'Scholarpeep' }}</span>
                            <span>•</span>
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Indicators -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-30 flex gap-2">
            <template x-for="i in slides" :key="i">
                <button @click="activeSlide = i - 1" class="h-1.5 rounded-full transition-all duration-300"
                    :class="activeSlide === i - 1 ? 'w-6 bg-primary-400' : 'w-1.5 bg-white/40 hover:bg-white/60'">
                </button>
            </template>
        </div>
    </div>
@endif