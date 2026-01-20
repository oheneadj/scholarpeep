<div class="bg-gray-50 min-h-screen">

    <!-- Hero Section (Featured Post) -->
    <!-- Hero Section (Featured Slider) -->
    @if($featuredPosts->count() > 0)
        <section class="relative bg-white border-b border-gray-100 overflow-hidden group" x-data="{ 
                    activeSlide: 0, 
                    slides: {{ $featuredPosts->count() }},
                    timer: null,
                    next() { this.activeSlide = (this.activeSlide + 1) % this.slides },
                    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides },
                    startTimer() { this.timer = setInterval(() => this.next(), 6000) },
                    stopTimer() { clearInterval(this.timer) }
                }" x-init="startTimer()" @mouseenter="stopTimer()" @mouseleave="startTimer()">

            <div class="absolute inset-0 bg-primary-50/30 opacity-20 pointer-events-none transform scale-150 blur-3xl">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
                <div class="relative min-h-[500px] md:min-h-[400px]">
                    @foreach($featuredPosts as $index => $post)
                        <div x-show="activeSlide === {{ $index }}" x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 translate-x-12"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-500 absolute top-0 left-0 w-full"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 -translate-x-12"
                            class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center w-full">

                            <!-- Content -->
                            <div class="space-y-6">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-[10px] font-bold uppercase tracking-widest">
                                        Featured
                                    </span>
                                    <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">
                                        {{ $post->published_at->format('M j, Y') }}
                                    </span>
                                </div>

                                <h1
                                    class="text-4xl md:text-6xl font-bold text-gray-900 leading-[1.1] tracking-tight hover:text-primary-600 transition-colors duration-300">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h1>

                                <p class="text-xl text-gray-500 leading-relaxed font-medium line-clamp-3">
                                    {{ $post->excerpt }}
                                </p>

                                <div class="flex items-center gap-4 pt-4">
                                    <img src="{{ $post->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}"
                                        class="w-12 h-12 rounded-full ring-4 ring-gray-50 shadow-sm border border-white">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $post->author->name }}</p>
                                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Scholarpeep
                                            Editorial</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Image -->
                            <div
                                class="relative aspect-[4/3] md:aspect-square rounded-2xl overflow-hidden shadow-2xl border border-gray-100 group/image">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent z-10 opacity-60">
                                </div>
                                <img src="{{ $post->featured_image_url }}"
                                    class="w-full h-full object-cover transform group-hover/image:scale-110 transition-transform duration-[1.5s]">

                                <div class="absolute bottom-8 right-8 z-20">
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                        class="w-16 h-16 rounded-full bg-white text-primary-600 flex items-center justify-center hover:scale-110 transition-transform shadow-lg hover:bg-primary-600 hover:text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Slider Controls -->
                @if($featuredPosts->count() > 1)
                    <div class="flex items-center gap-6 mt-8 md:mt-0 md:absolute md:bottom-12 md:left-8 z-20">
                        <button @click="prev()"
                            class="group w-12 h-12 rounded-full flex items-center justify-center text-gray-400 hover:text-primary-600 transition-all hover:-translate-y-0.5">
                            <svg class="w-6 h-6 transform transition-transform group-hover:-translate-x-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <div
                            class="flex gap-2.5 bg-white/50 backdrop-blur-sm px-4 py-2 rounded-full border border-white/20 shadow-sm">
                            <template x-for="i in slides" :key="i">
                                <button @click="activeSlide = i - 1"
                                    class="h-1.5 rounded-full transition-all duration-500 relative overflow-hidden"
                                    :class="activeSlide === i - 1 ? 'w-10 bg-primary-600' : 'w-2 bg-gray-300 hover:bg-gray-400'">
                                </button>
                            </template>
                        </div>

                        <button @click="next()"
                            class="group w-12 h-12 rounded-full flex items-center justify-center text-gray-400 hover:text-primary-600 transition-all hover:-translate-y-0.5">
                            <svg class="w-6 h-6 transform transition-transform group-hover:translate-x-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Filter Bar -->
        <div class="mb-12 overflow-x-auto no-scrollbar pb-2">
            <div class="flex gap-3">
                <button wire:click="setCategory(null)"
                    class="px-6 py-2.5 rounded-full text-sm font-bold whitespace-nowrap transition-all border {{ is_null($selectedCategory) ? 'bg-primary-600 border-primary-600 text-white shadow-lg shadow-primary-500/30' : 'bg-white border-gray-200 text-gray-600 hover:border-gray-300 hover:bg-gray-50' }}">
                    All Stories
                </button>
                @foreach($categories as $category)
                    <button wire:click="setCategory('{{ $category }}')"
                        class="px-6 py-2.5 rounded-full text-sm font-bold whitespace-nowrap transition-all border {{ $selectedCategory === $category ? 'bg-primary-600 border-primary-600 text-white shadow-lg shadow-primary-500/30' : 'bg-white border-gray-200 text-gray-600 hover:border-gray-300 hover:bg-gray-50' }}">
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <!-- Left Column: Articles Feed -->
            <div class="lg:col-span-8 space-y-8">
                @foreach($posts as $post)
                    <x-blog-card :post="$post" />
                @endforeach

                <!-- Pagination -->
                <div class="pt-8">
                    {{ $posts->links() }}
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <aside class="lg:col-span-4 space-y-8">

                <!-- Newsletter Widget -->
                <x-widgets.newsletter-widget />

                <!-- Trending Posts -->
                <x-widgets.trending-widget :posts="$popularPosts" />

                <!-- Categories -->
                <x-widgets.categories-widget :categories="$categories" />

                <!-- Sticky Promo Card -->
                <x-promo-card />

            </aside>
        </div>
    </div>
</div>