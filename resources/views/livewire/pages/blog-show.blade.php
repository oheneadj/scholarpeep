@section('meta')
    <script type="application/ld+json">
                                                                                                                {
                                                                                                                  "@@context": "https://schema.org",
                                                                                                                  "@@type": "BlogPosting",
                                                                                                                  "headline": "{{ $post->title }}",
                                                                                                                  "description": "{{ Str::limit(strip_tags($post->excerpt), 160) }}",
                                                                                                                  "image": "{{ $post->featured_image_url }}",
                                                                                                                  "author": {
                                                                                                                    "@@type": "Person",
                                                                                                                    "name": "{{ $post->author->name }}"
                                                                                                                  },
                                                                                                                  "publisher": {
                                                                                                                    "@@type": "Organization",
                                                                                                                    "name": "Scholarpeep",
                                                                                                                    "logo": {
                                                                                                                      "@@type": "ImageObject",
                                                                                                                      "url": "{{ asset('img/logo.png') }}"
                                                                                                                    }
                                                                                                                  },
                                                                                                                  "datePublished": "{{ $post->published_at }}",
                                                                                                                  "mainEntityOfPage": {
                                                                                                                    "@@type": "WebPage",
                                                                                                                    "@@id": "{{ route('blog.show', $post->slug) }}"
                                                                                                                  }
                                                                                                                }
                                                                                                                </script>
@endsection

<div class="bg-white min-h-screen font-sans text-gray-900" x-data="{ 
    scrolled: false,
    scrolledPercentage: 0,
    updateScroll() {
        this.scrolled = window.pageYOffset > 100;
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        this.scrolledPercentage = (winScroll / height) * 100;
    }
}" @scroll.window="updateScroll()" x-init="updateScroll()">
    <!-- Progress Bar -->
    <div class="fixed top-0 left-0 h-1 bg-gradient-to-r from-primary-500 to-purple-600 z-50 transition-all duration-300"
        :style="'width: ' + scrolledPercentage + '%'" id="scroll-progress"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Breadcrumbs / Top Tags -->
        <div class="flex items-center gap-3 mb-8 text-xs font-bold uppercase tracking-widest text-gray-400">
            <a href="{{ route('blog.index') }}" class="hover:text-primary-600 transition-colors">Blog</a>
            <span>/</span>
            <span class="text-primary-600">Trends</span>
        </div>

        <!-- Hero Section: Split Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center mb-20">
            <!-- Left: Text Content -->
            <div class="lg:col-span-5 space-y-8">
                <div class="space-y-4">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-[1.1] tracking-tight">
                        {{ $post->title }}
                    </h1>
                    <p class="text-xl text-gray-500 font-medium leading-relaxed">
                        {{ $post->excerpt }}
                    </p>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                    <img src="{{ $post->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}"
                        alt="{{ $post->author->name }}" class="w-12 h-12 rounded-full ring-4 ring-gray-50 object-cover">
                    <div>
                        <p class="font-bold text-gray-900 text-base">{{ $post->author->name }}</p>
                        <div class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <span>{{ $post->published_at->format('M j, Y') }}</span>
                            <span>&bull;</span>
                            <span>5 min read</span>
                        </div>
                    </div>
                </div>

                <!-- Social Actions -->
                <div class="flex items-center gap-4" x-data="{ 
                    copied: false,
                    copyToClipboard() {
                        const text = window.location.href;
                        if (navigator.clipboard && window.isSecureContext) {
                            navigator.clipboard.writeText(text).then(() => {
                                this.copied = true;
                                setTimeout(() => this.copied = false, 2000);
                            });
                        } else {
                            const textArea = document.createElement('textarea');
                            textArea.value = text;
                            document.body.appendChild(textArea);
                            textArea.select();
                            try {
                                document.execCommand('copy');
                                this.copied = true;
                                setTimeout(() => this.copied = false, 2000);
                            } catch (err) {
                                console.error('Fallback: Unable to copy', err);
                            }
                            document.body.removeChild(textArea);
                        }
                    }
                }">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                        target="_blank"
                        class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-colors"
                        title="Share on Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                        target="_blank"
                        class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-sky-50 hover:text-sky-500 transition-colors"
                        title="Share on X">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}"
                        target="_blank"
                        class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-blue-50 hover:text-blue-700 transition-colors"
                        title="Share on LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </a>
                    <div class="h-6 w-px bg-gray-200 mx-2"></div>
                    <button @click="copyToClipboard"
                        class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-900 transition-colors"
                        title="Copy Link">
                        <svg x-show="!copied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <svg x-show="copied" x-cloak class="w-5 h-5 text-success-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Right: Hero Image -->
            <div class="lg:col-span-7">
                <div
                    class="relative aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl bg-gray-100 border border-gray-100 group">
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                        class="relative w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                </div>
            </div>
        </div>

        <!-- Main Layout: Content + Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">

            <!-- Left Floating Metabar -->
            <x-metabar :title="$post->title" :readingTime="5" :showSave="false" />

            <!-- Main: Article Content -->
            <main class="lg:col-span-7 space-y-16">
                <!-- Content -->
                <article
                    class="prose prose-lg prose-slate prose-headings:font-bold prose-headings:text-gray-900 prose-p:text-gray-600 prose-p:leading-8 prose-a:text-primary-600 hover:prose-a:text-primary-700 prose-img:rounded-2xl prose-img:shadow-xl max-w-none mb-20">

                    <div class="border-l-4 border-primary-500 pl-6 py-2 my-10 bg-primary-50/30 rounded-r-2xl">
                        <p class="text-xl font-medium text-gray-800 italic leading-relaxed m-0">
                            "Scholarships are not just financial aid; they are investments in the future potential of
                            brilliant minds."
                        </p>
                    </div>



                    {!! $post->renderRichContent('content') !!}



                    <!-- App-like Promo Block (Example) -->
                    <div
                        class="not-prose my-16 bg-gray-900 rounded-2xl p-8 md:p-12 text-white relative overflow-hidden shadow-2xl">
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-primary-500 rounded-full filter blur-[80px] opacity-20">
                        </div>
                        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                            <div class="flex-1">
                                <span
                                    class="text-primary-300 font-bold uppercase tracking-widest text-[10px] mb-2 block">Premium
                                    Access</span>
                                <h3 class="text-2xl font-bold mb-4">Unlock 50,000+ Verified Scholarships</h3>
                                <p class="text-gray-400 text-sm mb-6">Get personalized matches, deadline tracking, and
                                    AI-powered essay assistance.</p>
                                <a href="#"
                                    class="inline-block px-6 py-3 bg-white text-gray-900 font-bold rounded-full text-sm hover:bg-primary-50 transition-colors shadow-lg active:scale-95">Start
                                    Free Trial</a>
                            </div>
                            <!-- Mockup Graphic -->
                            <div
                                class="w-32 h-32 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/10 shrink-0 transform rotate-6">
                                <span class="text-4xl">🎓</span>
                            </div>
                        </div>
                    </div>

                </article>

                <!-- Read Next Section -->
                <div class="border-t border-gray-100 pt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                        <span class="w-2 h-8 bg-primary-600 rounded-full"></span>
                        Read Next
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($relatedPosts as $related)
                            <a href="{{ route('blog.show', $related->slug) }}" class="group block">
                                <div
                                    class="aspect-[16/10] bg-gray-100 rounded-2xl overflow-hidden mb-4 relative shadow-sm border border-gray-100">
                                    <div
                                        class="absolute inset-0 bg-gray-900/0 group-hover:bg-gray-900/10 transition-colors z-10">
                                    </div>
                                    <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                        loading="lazy">
                                </div>
                                <div class="space-y-2">
                                    <div
                                        class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-primary-600">
                                        <span>Article</span>
                                        <span class="text-gray-300">&bull;</span>
                                        <span>{{ $related->published_at->format('M j') }}</span>
                                    </div>
                                    <h3
                                        class="text-lg font-bold text-gray-900 leading-tight group-hover:text-primary-600 transition-colors">
                                        {{ $related->title }}
                                    </h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Bottom Newsletter -->
                <x-widgets.newsletter-cta />

                <!-- Advertisement Section -->
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100">
                    <x-ad position="{{ \App\Enums\AdPosition::IN_TEXT }}" />
                </div>
            </main>

            <!-- Right: Sticky Sidebar -->
            <aside class="lg:col-span-4 space-y-12">

                <!-- Author Widget -->
                <x-widgets.author-widget :name="$post->author->name" role="Senior Editor" :bio="$post->author->bio ?? 'Passionate about democratizing education access and finding the best funding opportunities for students worldwide.'" :avatar="$post->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name)" title="About" location="New York, NY" :socials="[
        'x' => '#',
        'facebook' => '#',
        'instagram' => '#',
        'linkedin' => '#'
    ]" /><!-- Featured Posts Slider -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold font-display text-gray-950 px-2 flex items-center gap-3">
                        <span class="w-2 h-8 bg-primary-600 rounded-full"></span>
                        Top Stories
                    </h3>
                    <x-widgets.featured-posts-slider :posts="$featuredPosts" />
                </div>

                <!-- Popular Posts -->
                {{-- <x-widgets.popular-posts-widget :posts="$popularPosts" title="Stories That Matter" /> --}}

                <!-- Topics -->
                <x-widgets.topics-list :topics="$topics" title="Scholarship Topics" />

                <!-- Featured Scholarships -->
                <x-widgets.featured-scholarships-widget :scholarships="$featuredScholarships"
                    title="Top Funding Opportunities" />

                <!-- Affiliate Tools Widget -->
                <x-widgets.affiliate-tools-widget />

                <!-- Newsletter Widget -->
                <x-widgets.newsletter-widget />

                <!-- Sticky Ad Widget -->
                <x-widgets.ad-widget />

            </aside>
        </div>
    </div>
</div>