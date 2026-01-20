<div class="space-y-24 pb-24" x-data="{ premiumIndex: 0, premiumCount: {{ $premiumScholarships->count() }} }"
    x-init="if(premiumCount > 0) setInterval(() => { premiumIndex = (premiumIndex + 1) % premiumCount }, 30000)">
    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center pt-24 pb-32 overflow-hidden bg-white"
        x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 100)">

        <!-- Premium Multi-layered Background -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <!-- Animated Mesh Gradients -->
            <div
                class="absolute top-[-20%] right-[-10%] w-[1000px] h-[1000px] bg-primary-100/40 rounded-full blur-[120px] animate-pulse-slow">
            </div>
            <div
                class="absolute bottom-[-10%] left-[-5%] w-[800px] h-[800px] bg-soft-purple/30 rounded-full blur-[120px] animate-pulse-slow delay-1000">
            </div>
            <div
                class="absolute top-[20%] left-[15%] w-[500px] h-[500px] bg-primary-50/50 rounded-full blur-[100px] animate-bounce duration-[15s]">
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">

                <!-- Hero Content -->
                <div class="lg:col-span-7 xl:col-span-8 flex flex-col justify-center">

                    <!-- Announcement Badge -->
                    <div x-show="visible" x-transition:enter="transition ease-out duration-1000 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-4" class="mb-8">
                        <span
                            class="inline-flex items-center space-x-2 bg-gradient-to-r from-primary-50 to-white text-primary-700 px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-sm border border-primary-100">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-600"></span>
                            </span>
                            <span>{{ number_format($scholarshipCount) }}+ New Scholarships Added Recently</span>
                        </span>
                    </div>

                    <!-- Main Heading -->
                    <h1 x-show="visible" x-transition:enter="transition ease-out duration-1000 delay-300"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        class="text-4xl sm:text-7xl xl:text-8xl font-black text-gray-950 font-display leading-[1.05] tracking-tight mb-8">
                        Your Future <br />
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-primary-400">Doesn't
                            Have</span> <br />
                        To Be Expensive.
                    </h1>

                    <!-- Subtitle -->
                    <p x-show="visible" x-transition:enter="transition ease-out duration-1000 delay-500"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        class="text-xl text-gray-500 leading-relaxed max-w-2xl mb-12 font-medium">
                        Unlock global opportunities with high-impact scholarships tailored for your academic brilliance.
                        Simplified discovery, verified sources, and expert guidance.
                    </p>

                    <!-- Glassmorphism Search Bar -->
                    <div x-show="visible" x-transition:enter="transition ease-out duration-1000 delay-700"
                        x-transition:enter-start="opacity-0 scale-95" class="max-w-2xl">
                        <form action="{{ route('scholarships.index') }}" method="GET"
                            class="relative flex flex-col sm:flex-row gap-4 p-2 bg-white/40 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-2xl shadow-primary-900/10 hover:shadow-primary-900/20 transition-all duration-500">
                            <div class="flex-1 relative group">
                                <div
                                    class="absolute inset-y-0 left-6 flex items-center pointer-events-none transition-transform group-focus-within:scale-110">
                                    <svg class="h-6 w-6 text-primary-400 group-focus-within:text-primary-600"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input id="search" name="q" type="text"
                                    placeholder="Degree, Field of study, or Keywords"
                                    class="block w-full pl-16 pr-6 py-5 text-lg text-gray-900 placeholder-gray-400 bg-white shadow-inner border border-gray-100 rounded-[2rem] focus:ring-4 focus:ring-primary-500/5 focus:border-primary-400 transition-all outline-none">
                            </div>
                            <button type="submit"
                                class="px-10 py-5 rounded-[2rem] shadow-xl shadow-primary-600/30 text-white bg-primary-600 font-bold hover:bg-primary-700 hover:shadow-primary-600/40 transform hover:-translate-y-1 transition-all active:scale-[0.95] flex items-center justify-center gap-2">
                                <span>Search</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </form>

                        <!-- Enhanced Quick Filters -->
                        <div class="mt-8 flex flex-wrap items-center gap-3 px-2">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">Top
                                Destinations:</span>
                            @foreach ($popularCountries->take(4) as $country)
                                <a href="{{ route('scholarships.index', ['country' => $country->slug]) }}"
                                    class="group px-4 py-2 bg-white/60 backdrop-blur-md rounded-full text-xs font-bold text-gray-600 border border-gray-100 hover:border-primary-300 hover:bg-white hover:text-primary-700 transition-all shadow-sm hover:shadow-md flex items-center gap-2 active:scale-95">
                                    <x-dynamic-component :component="'flag-country-' . $country->iso_alpha2"
                                        class="w-4 h-4 rounded-full shadow-sm" />
                                    {{ $country->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Visual: Dynamic Premium Carousel -->
                <div class="lg:col-span-5 xl:col-span-4 hidden lg:block relative" x-show="visible"
                    x-transition:enter="transition ease-out duration-1000 delay-1000"
                    x-transition:enter-start="opacity-0 translate-x-12">
                    <div class="relative w-full aspect-[4/5] flex items-center justify-center">
                        <div
                            class="absolute inset-0 bg-primary-500 opacity-20 scale-110 rounded-full blur-[100px] animate-pulse">
                        </div>

                        <!-- Carousel Slides -->
                        <div class="relative z-10 w-full h-[500px]">
                            @foreach($premiumScholarships as $index => $premium)
                                <div x-show="premiumIndex === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-700"
                                    x-transition:enter-start="opacity-0 scale-95 translate-x-8"
                                    x-transition:enter-end="opacity-100 scale-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-500"
                                    x-transition:leave-start="opacity-100 scale-100 translate-x-0"
                                    x-transition:leave-end="opacity-0 scale-95 -translate-x-8" class="absolute inset-0">
                                    <x-scholarship-card :scholarship="$premium" view="grid"
                                        class="h-full border-2 border-purple-500 shadow-2xl shadow-purple-950/20" />

                                    <!-- Premium Floating Badge -->
                                    <div
                                        class="absolute -top-4 -right-4 bg-purple-600 text-white p-3 rounded-2xl shadow-xl animate-bounce-slow z-20">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    </div>
                                </div>
                            @endforeach

                            @if($premiumScholarships->isEmpty())
                                <div class="relative w-full h-full flex items-center justify-center">
                                    <div
                                        class="absolute top-[10%] left-0 w-3/4 aspect-square rounded-3xl overflow-hidden shadow-2xl border-4 border-white -rotate-6 transform hover:rotate-0 transition-all duration-700">
                                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div
                                        class="absolute bottom-[5%] right-0 w-3/4 aspect-square rounded-3xl overflow-hidden shadow-2xl border-4 border-white rotate-12 transform hover:rotate-0 transition-all duration-700 delay-150">
                                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800"
                                            class="w-full h-full object-cover">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Carousel Indicators -->
                        @if($premiumScholarships->count() > 1)
                            <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 flex gap-3 z-20">
                                @foreach($premiumScholarships as $index => $premium)
                                    <button @click="premiumIndex = {{ $index }}"
                                        class="h-1.5 transition-all duration-500 rounded-full"
                                        :class="premiumIndex === {{ $index }} ? 'w-8 bg-purple-600' : 'w-2 bg-gray-300 hover:bg-gray-400'"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Country Carousel -->
    @if($countries->count() > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-[-4rem] relative z-20">
            <div x-data="{ 
                                                                                            scroll: 0, 
                                                                                            max: 0,
                                                                                            updateMax() { 
                                                                                                this.max = $refs.container.scrollWidth - $refs.container.clientWidth 
                                                                                            } 
                                                                                        }" x-init="updateMax()"
                @resize.window="updateMax()" class="relative group">
                <div x-ref="container" class="flex gap-4 overflow-x-auto no-scrollbar scroll-smooth pb-8 pt-4">
                    @foreach($countries as $country)
                        <a href="{{ route('scholarships.index', ['country' => $country->slug]) }}" class="flex-none w-40 group">
                            <div
                                class="bg-white rounded-xl p-4 shadow-lg shadow-gray-200/50 border border-gray-100 hover:border-primary-200 hover:shadow-primary-500/10 hover:-translate-y-1 transition-all duration-300 h-full flex flex-col items-center justify-center text-center">
                                <div
                                    class="w-16 h-16 rounded overflow-hidden mb-3 group-hover:scale-110 transition-transform duration-500 relative">
                                    <x-dynamic-component :component="'flag-country-' . $country->iso_alpha2"
                                        class="w-full h-full object-cover" />
                                    <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                                </div>
                                <span
                                    class="font-bold text-gray-800 text-sm leading-tight group-hover:text-primary-600 transition-colors line-clamp-2 min-h-[2.5em] flex items-center justify-center">
                                    {{ $country->name }}
                                </span>
                                <span
                                    class="text-[10px] font-bold text-primary-400 uppercase tracking-wider mt-2 bg-primary-50 px-2 py-1 rounded-full group-hover:bg-primary-100 transition-colors">
                                    View Options
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Nav Arrows -->
                <button @click="$refs.container.scrollLeft -= 300"
                    class="absolute left-[-20px] top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-2xl border border-gray-100 flex items-center justify-center text-gray-400 hover:text-primary-600 hover:scale-110 transition-all opacity-0 group-hover:opacity-100 z-30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="$refs.container.scrollLeft += 300"
                    class="absolute right-[-20px] top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-2xl border border-gray-100 flex items-center justify-center text-gray-400 hover:text-primary-600 hover:scale-110 transition-all opacity-0 group-hover:opacity-100 z-30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </section>
    @endif

    <!-- Scholarships by Country (Featured) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-baseline md:items-end gap-4 mb-12">
            <div>
                <h2 class="text-3xl font-bold font-display text-gray-900 mb-2">Featured by Country</h2>
                <p class="text-gray-500">Hand-picked opportunities for the most popular destinations.</p>
            </div>
            <a href="{{ route('scholarships.index') }}"
                class="px-6 py-3 bg-primary-700 text-white font-bold rounded-full hover:bg-primary-600 transition-all flex items-center gap-2 group text-sm">
                View all by country
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredScholarships->take(3) as $scholarship)
                <x-scholarship-card :scholarship="$scholarship" />
            @endforeach
        </div>
    </section>

    <!-- Scholarships by Type -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="absolute -right-20 top-0 w-80 h-80 bg-blob-purple opacity-30 pointer-events-none"></div>
        <div class="p-12 border border-blue-50/50  relative overflow-hidden">
            <div class="absolute inset-0 bg-soft-blue/10"></div>
            <div class="relative z-10">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold font-display text-gray-900 mb-6">Discover by Scholarship Type</h2>
                    <div class="flex flex-wrap justify-center gap-3">
                        @php
                            $colors = [
                                'bg-purple-500 text-white hover:bg-purple-600 hover:text-white',
                                'bg-blue-500 text-white hover:bg-blue-600 hover:text-white',
                                'bg-pink-500 text-white hover:bg-pink-600 hover:text-white',
                                'bg-orange-500 text-white hover:bg-orange-600 hover:text-white',
                                'bg-teal-500 text-white hover:bg-teal-600 hover:text-white',
                                'bg-indigo-500 text-white hover:bg-indigo-600 hover:text-white',
                            ];
                        @endphp
                        @foreach($scholarshipTypes as $type)
                            <button type="button" wire:click.prevent="setType('{{ $type->slug }}')"
                                class="px-6 py-3 rounded-full text-sm font-bold transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5
                                                                                                                                                                                                                                                                                                {{ $selectedTypeSlug === $type->slug ? 'ring-4 ring-offset-2 ring-primary-200 scale-105 ' . $colors[$loop->index % count($colors)] : 'bg-white border border-blue-200 text-gray-600 hover:text-white ' . str_replace('text-white', '', $colors[$loop->index % count($colors)]) }}">
                                {{ $type->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($typeSectionScholarships as $scholarship)
                        <x-scholarship-card :scholarship="$scholarship" />
                    @empty
                        <div class="col-span-3 text-center py-10 text-gray-500">
                            No scholarships found for this type.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Visual Banner / CTA -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 overflow-hidden py-12" x-data="{ 
            mouseX: 0, 
            mouseY: 0,
            isVisible: false 
        }" @mousemove="mouseX = $event.clientX; mouseY = $event.clientY" x-intersect.once="isVisible = true">

        <div
            class="relative rounded-[3rem] overflow-hidden bg-gray-950 px-8 py-16 md:px-20 md:py-24 flex flex-col lg:flex-row items-center justify-between gap-16 group shadow-2xl border border-white/10 isolate">

            <!-- Premium Animated Background -->
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary-600 opacity-20 rounded-full blur-[120px] animate-pulse-slow transition-transform duration-1000"
                    :style="`transform: translate(${mouseX * -0.01}px, ${mouseY * -0.01}px)`"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-600 opacity-20 rounded-full blur-[120px] animate-pulse-slow transition-transform duration-1000"
                    :style="`transform: translate(${mouseX * 0.01}px, ${mouseY * 0.01}px)`"></div>
            </div>

            <!-- Pattern Overlay -->
            <div class="absolute inset-0 opacity-[0.05] pointer-events-none"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')">
            </div>

            <div class="relative z-10 max-w-2xl text-center lg:text-left" x-show="isVisible"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 translate-y-12" x-transition:enter-end="opacity-100 translate-y-0">

                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 backdrop-blur-md border border-white/10 text-primary-200 text-xs font-bold uppercase tracking-widest mb-8">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-success-500"></span>
                    </span>
                    Smart AI Matching Engine
                </div>

                <h2 class="text-4xl md:text-6xl font-black text-white mb-8 leading-[1.1] font-display tracking-tight">
                    Can't find your <br>
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 via-purple-400 to-primary-400 bg-[length:200%_auto] animate-gradient">perfect
                        match?</span>
                </h2>

                <p class="text-primary-100/80 text-xl leading-relaxed font-medium mb-12">
                    Our AI scans thousands of new opportunities daily across 150+ countries. Tell us your story, and
                    we'll bring the perfect scholarships directly to your inbox.
                </p>

                <div class="flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start">
                    <a href="{{ route('register') }}"
                        class="group relative inline-flex items-center gap-3 px-10 py-5 bg-white text-primary-950 font-black rounded-[2rem] text-lg shadow-2xl hover:shadow-primary-500/20 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 overflow-hidden">
                        <span>Get Personalized Matches</span>
                        <div
                            class="w-8 h-8 rounded-full bg-primary-900 text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </div>
                    </a>
                    <div class="flex -space-x-3 items-center">
                        @for($i = 1; $i <= 4; $i++)
                            <img class="w-10 h-10 rounded-full border-4 border-gray-900"
                                src="https://i.pravatar.cc/150?u={{ $i }}" alt="Student">
                        @endfor
                        <span class="pl-6 text-sm font-bold text-primary-200/60">Joined by
                            {{ number_format($userCount) }}+ students</span>
                    </div>
                </div>
            </div>

            <!-- Visual Asset: Glassmorphic Match Card -->
            <div class="relative z-10 hidden lg:block" x-show="isVisible"
                x-transition:enter="transition ease-out duration-1000 delay-300"
                x-transition:enter-start="opacity-0 scale-90 translate-x-12"
                x-transition:enter-end="opacity-100 scale-100 translate-x-0">

                <div class="relative p-1 animate-float-slow">
                    <div
                        class="w-[380px] rounded-[2.5rem] bg-white/10 backdrop-blur-2xl border border-white/20 p-8 shadow-2xl shadow-black/40 relative overflow-hidden group/card">
                        <!-- Card Decorative background -->
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-primary-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
                        </div>

                        <div class="flex items-start justify-between mb-8">
                            <div
                                class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-primary-400 border border-white/10">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full bg-success-500/20 text-success-400 text-[10px] font-black uppercase tracking-widest border border-success-500/20">98%
                                Match</span>
                        </div>

                        <div class="space-y-4">
                            <div class="h-2 w-24 bg-white/20 rounded-full"></div>
                            <div class="h-6 w-full bg-white/10 rounded-xl"></div>
                            <div class="h-6 w-3/4 bg-white/10 rounded-xl"></div>
                        </div>

                        <div class="mt-10 pt-8 border-t border-white/10 flex items-center justify-between">
                            <div class="flex gap-2">
                                <div class="w-8 h-8 rounded-lg bg-primary-500/30"></div>
                                <div class="w-8 h-8 rounded-lg bg-purple-500/30"></div>
                            </div>
                            <div class="h-10 w-24 bg-white rounded-full"></div>
                        </div>

                        <!-- Sparkle Effects -->
                        <div class="absolute -bottom-2 -left-2 w-24 h-24 bg-purple-600/30 rounded-full blur-2xl"></div>
                    </div>

                    <!-- Small overlapping floating card -->
                    <div
                        class="absolute -bottom-6 -left-12 w-48 rounded-2xl bg-white p-4 shadow-2xl transform -rotate-6 border border-gray-100 hidden lg:block group-hover/card:rotate-0 transition-transform duration-500">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-success-100 text-success-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-900 leading-none">APPLICATION</p>
                                <p class="text-[9px] text-gray-500 font-bold">Matching successful!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scholarships by Field -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="absolute -left-20 bottom-0 w-80 h-80 bg-blob-pink opacity-20 pointer-events-none"></div>
        <div class="flex flex-col md:flex-row justify-between items-start gap-12 relative z-10">
            <div class="w-full lg:w-1/3 sticky top-24">
                <h2 class="text-3xl font-bold font-display text-gray-900 mb-6">Explore by Field of Study</h2>
                <p class="text-gray-500 mb-8 leading-relaxed">Whether you're into STEM, Arts, or Medicine, there's a
                    specialized scholarship waiting for you.</p>
                <div class="grid grid-cols-1 gap-3 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($fieldsOfStudy->take(10) as $field)
                                    <button type="button" wire:click.prevent="setField('{{ $field->slug }}')"
                                        class="flex items-center justify-between p-4 border rounded-2xl w-full text-left transition-all group/field
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            {{ $selectedFieldSlug === $field->slug
                        ? 'bg-purple-600 border-purple-600 shadow-xl shadow-purple-900/10'
                        : 'bg-white/80 border-purple-50 hover:bg-white hover:border-purple-200 hover:shadow-lg hover:shadow-purple-900/5' }}">
                                        <span
                                            class="font-bold text-sm transition-colors {{ $selectedFieldSlug === $field->slug ? 'text-white' : 'text-gray-700 group-hover/field:text-purple-700' }}">
                                            {{ $field->name }}
                                        </span>
                                        <div
                                            class="w-8 h-8 rounded-full flex items-center justify-center transition-all
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {{ $selectedFieldSlug === $field->slug ? 'bg-white/20 text-white' : 'bg-purple-50 text-purple-400 group-hover/field:bg-purple-100 group-hover/field:text-purple-600' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </button>
                    @endforeach
                </div>

                @if($selectedFieldSlug)
                    <a href="{{ route('scholarships.index', ['field' => $selectedFieldSlug]) }}"
                        class="mt-8 inline-flex items-center gap-2 text-primary-600 font-bold hover:gap-3 transition-all">
                        View all in {{ $fieldsOfStudy->where('slug', $selectedFieldSlug)->first()->name }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('scholarships.index') }}"
                        class="mt-8 inline-flex items-center gap-2 text-primary-600 font-bold hover:gap-3 transition-all">
                        View all fields of study
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                @endif
            </div>

            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($fieldSectionScholarships as $scholarship)
                    <x-scholarship-card :scholarship="$scholarship" />
                @empty
                    <div class="col-span-2 text-center py-10 text-gray-500">
                        No scholarships found for this field.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Scholarships by Program Level -->
    <section class="bg-gray-900 py-24 overflow-hidden relative">
        <!-- Modern Background Pattern -->
        <div
            class="absolute inset-0 opacity-20 pointer-events-none bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-indigo-900 via-gray-900 to-gray-900">
        </div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-blue-600/10 rounded-full blur-[120px] translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-1/2 h-full bg-purple-600/10 rounded-full blur-[120px] -translate-x-1/2">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold font-display text-white mb-6">Find Funding for Your Exact Level</h2>

                <div class="flex flex-wrap justify-center gap-4">
                    @foreach($educationLevels as $level)
                                    <button type="button" wire:click.prevent="setLevel('{{ $level->slug }}')"
                                        class="px-6 py-3 rounded-full font-bold transition-all border
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            {{ $selectedLevelSlug === $level->slug
                        ? 'bg-white text-primary-700 border-white shadow-[0_0_20px_rgba(255,255,255,0.3)] scale-105'
                        : 'bg-white/5 border-white/10 text-gray-300 hover:bg-white/10 hover:text-white hover:border-white/20' }}">
                                        {{ $level->name }}
                                    </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($levelSectionScholarships as $scholarship)
                    <x-scholarship-card :scholarship="$scholarship" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 mb-4">
                            <span class="text-3xl">🎓</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No scholarships found</h3>
                        <p class="text-gray-400">Try selecting a different level or view all available scholarships.</p>
                    </div>
                @endforelse
            </div>

            @if($selectedLevelSlug)
                <div class="text-center mt-12">
                    <a href="{{ route('scholarships.index', ['level' => $selectedLevelSlug]) }}"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-white text-gray-900 rounded-full font-bold hover:bg-gray-100 transition-all shadow-lg active:scale-95 group">
                        View all {{ $educationLevels->where('slug', $selectedLevelSlug)->first()->name }} Scholarships
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    @if($latestPosts->count() > 0)
        <!-- Modern Grid Blog Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative py-12">
            <div class="absolute -right-20 top-1/2 w-80 h-80 bg-blob-pink opacity-10 pointer-events-none"></div>

            <div class="flex flex-col md:flex-row justify-between items-end gap-4 mb-12 relative z-10">
                <div>
                    <span class="text-primary-600 font-bold uppercase tracking-widest text-sm mb-2 block">Latest
                        Insights</span>
                    <h2 class="text-3xl font-bold font-display text-gray-900">From the Scholarship Blog</h2>
                </div>
                <!-- View All Link -->
                <a href="{{ route('blog.index') }}"
                    class=" px-6 py-3 rounded-full bg-primary-600 text-white hover:bg-primary-700 font-medium transition-colors">View
                    All
                    Articles &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
                @foreach($latestPosts as $post)
                    <article
                        class="group bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full">
                        <!-- Image -->
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                            <img src="{{ Str::startsWith($post->featured_image, 'http') ? $post->featured_image : \Illuminate\Support\Facades\Storage::url($post->featured_image) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                alt="{{ $post->title }}">
                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span
                                    class="px-3 py-1.5 bg-white/90 backdrop-blur-md text-primary-700 text-[10px] font-bold uppercase tracking-widest rounded-lg shadow-sm">
                                    Guide
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8 flex flex-col flex-1">
                            <div class="flex items-center gap-3 text-xs text-gray-400 font-bold uppercase tracking-wider mb-4">
                                <span>{{ $post->published_at?->format('M j, Y') ?? $post->created_at->format('M j, Y') }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span>5 min read</span>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors line-clamp-2 leading-tight font-display">
                                <a href="#">{{ $post->title }}</a>
                            </h3>

                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-6 flex-1">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                            </p>

                            <!-- Author & Action -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-50 mt-auto">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $post->author?->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author?->name ?? 'Admin') }}"
                                        class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm">
                                    <span
                                        class="text-sm font-bold text-gray-700">{{ $post->author?->name ?? 'Scholarpeep Team' }}</span>
                                </div>
                                <a href="#"
                                    class="px-4 py-2 bg-black text-white text-xs font-bold uppercase tracking-wider rounded-lg hover:bg-primary-600 hover:text-white transition-all shadow-sm">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Success Stories Carousel -->
    <section class="bg-gray-50 py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-blob-yellow opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold font-display text-gray-900 mb-4 tracking-tight">Wall of <span
                        class="text-primary-600">Love</span> 💜</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Scholarpeep powers high-impact academic journeys
                    around the world.</p>
                <div class="flex items-center justify-center gap-2 mt-4 text-orange-500">
                    <span class="font-bold text-gray-900">4.8</span>
                    <div class="flex">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-gray-400 text-sm">on Trustpilot</span>
                </div>
            </div>

            @if($testimonials->isNotEmpty())
                <div x-data="{ 
                                                                        scroll: 0, 
                                                                        max: 0,
                                                                        autoplayInterval: null,
                                                                        paused: false,
                                                                        updateMax() { 
                                                                            this.max = $refs.testimonial_container.scrollWidth - $refs.testimonial_container.clientWidth 
                                                                        },
                                                                        startAutoplay() {
                                                                            this.autoplayInterval = setInterval(() => {
                                                                                if (!this.paused) {
                                                                                    if ($refs.testimonial_container.scrollLeft + $refs.testimonial_container.clientWidth >= $refs.testimonial_container.scrollWidth) {
                                                                                        $refs.testimonial_container.scrollLeft = 0;
                                                                                    } else {
                                                                                        $refs.testimonial_container.scrollLeft += 1;
                                                                                    }
                                                                                }
                                                                            }, 30);
                                                                        },
                                                                        stopAutoplay() {
                                                                            clearInterval(this.autoplayInterval);
                                                                        }
                                                                    }" x-init="updateMax(); startAutoplay()"
                    @resize.window="updateMa
                                                  x     ()" @mouseenter="paused = true" @mouseleave="paused = false"
                    class="relative group">
                    <div x-ref="testimonial_container"
                        class="flex gap-6 overflow-x-auto no-scrollbar pb-8 px-4 sm:px-0 scroll-smooth">
                        @foreach($testimonials as $story)
                            <x-success-story-card :story="$story" />
                        @endforeach
                    </div>

                    <!-- Enhanced Nav Arrows -->
                    <button @click="$refs.testimonial_container.scrollLeft -= 400"
                        class="absolute left-[-24px] top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-2xl border border-gray-100 flex items-center justify-center text-gray-400 hover:text-primary-600 hover:scale-110 transition-all opacity-0 group-hover:opacity-100 z-30 hidden md:flex">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="$refs.testimonial_container.scrollLeft += 400"
                        class="absolute right-[-24px] top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-2xl border border-gray-100 flex items-center justify-center text-gray-400 hover:text-primary-600 hover:scale-110 transition-all opacity-0 group-hover:opacity-100 z-30 hidden md:flex">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">Testimonials coming soon!</p>
                </div>
            @endif
        </div>
    </section>

</div>