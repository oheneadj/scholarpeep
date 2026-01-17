<div class="space-y-24 pb-24" x-data="{ premiumIndex: 0, premiumCount: {{ $premiumScholarships->count() }} }"
    x-init="if(premiumCount > 0) setInterval(() => { premiumIndex = (premiumIndex + 1) % premiumCount }, 30000)">
    <!-- Hero Section -->
    <section class="relative bg-white pt-20 pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0 h-full w-full overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] right-[-10%] w-[800px] h-[800px] bg-blob-blue opacity-60"></div>
            <div class="absolute bottom-0 left-[-10%] w-[600px] h-[600px] bg-blob-pink opacity-40"></div>
            <div class="absolute top-[20%] left-[10%] w-[400px] h-[400px] bg-blob-yellow opacity-30"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-12">
                <div
                    class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-8 lg:text-left flex flex-col justify-center">
                    <span
                        class="inline-flex items-center space-x-2 bg-primary-50 text-primary-700 px-4 py-1.5 rounded-full text-sm font-semibold mb-6 w-fit shadow-sm border border-primary-100">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-600"></span>
                        </span>
                        <span>1,200+ New Scholarships Added This Month</span>
                    </span>
                    <h1
                        class="text-4xl tracking-tight font-bold text-gray-900 sm:text-5xl md:text-6xl lg:text-5xl xl:text-7xl font-display leading-[1.1]">
                        <span class="block">Your Future Doesn't</span>
                        <span class="block text-primary-600">Have to be Expensive.</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-500 sm:text-xl leading-relaxed max-w-2xl">
                        Find and apply to thousands of scholarships tailored to your background, interests, and
                        educational goals. Simplified discovery for the modern student.
                    </p>
                    <div class="mt-10 sm:max-w-xl sm:mx-auto sm:text-center lg:text-left lg:mx-0">
                        <form action="{{ route('scholarships.index') }}" method="GET"
                            class="mt-3 flex flex-col sm:flex-row gap-3">
                            <div class="flex-1 relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input id="search" name="q" type="text"
                                    placeholder="Degree, Field of study, or Keywords"
                                    class="block w-full pl-14 pr-5 py-4 text-base text-gray-900 placeholder-gray-400 bg-white border border-gray-200 rounded-full shadow-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none">
                            </div>
                            <button type="submit"
                                class="px-8 py-4 rounded-full shadow-lg shadow-primary-600/20 text-white bg-primary-600 font-bold hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all active:scale-[0.98]">
                                Find Scholarships
                            </button>
                        </form>
                        <div class="mt-10 flex flex-wrap items-center gap-3">
                            <span class="text-xs font-bold text-blue-400 uppercase tracking-widest mr-2">Quick
                                Filters:</span>

                            {{-- Popular Countries --}}
                            @foreach ($popularCountries as $country)
                                <a href="{{ route('scholarships.index', ['country' => $country->slug]) }}"
                                    class="group px-4 py-2 bg-white text-blue-600 rounded-full text-xs font-bold ring-1 ring-gray-200 hover:ring-primary-300 hover:bg-primary-50 hover:text-primary-700 transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                                    <x-dynamic-component :component="'flag-country-' . $country->iso_alpha2"
                                        class="w-4 h-4 rounded-full  group-hover:grayscale-0 transition-all" />
                                    {{ $country->name }}
                                </a>
                            @endforeach

                            {{-- Popular Education Levels --}}
                            @foreach ($popularLevels as $level)
                                <a href="{{ route('scholarships.index', ['level' => $level->slug]) }}"
                                    class="px-4 py-2 bg-white text-blue-600 rounded-full text-xs font-bold ring-1 ring-gray-200 hover:ring-primary-300 hover:bg-primary-50 hover:text-primary-700 transition-all shadow-sm hover:shadow-md">
                                    {{ $level->name }}
                                </a>
                            @endforeach

                            {{-- Popular Scholarship Types --}}
                            @foreach ($popularTypes as $type)
                                <a href="{{ route('scholarships.index', ['types' => [$type->slug]]) }}"
                                    class="px-4 py-2 bg-white text-blue-600 rounded-full text-xs font-bold ring-1 ring-gray-200 hover:ring-primary-300 hover:bg-primary-50 hover:text-primary-700 transition-all shadow-sm hover:shadow-md">
                                    {{ $type->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-16 relative lg:mt-0 lg:col-span-4 hidden lg:block">
                    <div class="relative w-full aspect-square flex items-center justify-center">
                        <div class="absolute inset-0 bg-blob-blue opacity-50 scale-150 rounded-full blur-3xl"></div>
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800"
                            class="relative z-10 w-full h-auto rounded-3xl shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-500"
                            alt="Students collaborating">
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                                            }" x-init="updateMax()" @resize.window="updateMax()" class="relative group">
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
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        <div
            class="relative rounded-3xl overflow-hidden bg-gray-900 px-8 py-16 md:px-20 md:py-24 flex flex-col md:flex-row items-center justify-between gap-12 group shadow-2xl border border-white/10 isolate">

            <!-- Interactive Background Elements -->
            <div
                class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-900 to-primary-950 opacity-90 transition-opacity duration-500">
            </div>

            <!-- Parallax blobs -->
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary-500/30 rounded-full blur-[120px] mix-blend-screen transition-transform duration-75 ease-out"
                :style="`transform: translate(${mouseX * -0.02}px, ${mouseY * -0.02}px)`"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-500/30 rounded-full blur-[100px] mix-blend-screen transition-transform duration-75 ease-out"
                :style="`transform: translate(${mouseX * 0.02}px, ${mouseY * 0.02}px)`"></div>

            <!-- Pattern Overlay -->
            <div class="absolute inset-0 opacity-[0.03] text-white"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'currentColor\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')">
            </div>

            <div class="relative z-10 max-w-2xl text-center md:text-left">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 text-primary-200 text-xs font-bold uppercase tracking-widest mb-6 backdrop-blur-md border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-success-500 animate-pulse"></span>
                    Updated Daily
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight font-display tracking-tight">
                    Can't find your <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary-200 to-purple-200">perfect
                        match?</span>
                </h2>
                <p class="text-primary-100 text-lg opacity-90 leading-relaxed font-light">
                    Our experts add hundreds of new scholarships every single day. Tell us your background, and our AI
                    will notify you the moment a matching opportunity arrives.
                </p>
            </div>

            <div class="relative z-10 shrink-0">
                <a href="#"
                    class="group relative inline-flex items-center gap-3 px-10 py-5 bg-white text-primary-900 font-bold rounded-full text-lg shadow-xl hover:shadow-2xl hover:bg-primary-50 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <span
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></span>
                    <span>Get Personalized Matches</span>
                    <div
                        class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center group-hover:bg-primary-600 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </a>
                <p class="mt-4 text-center text-sm text-primary-200/60">Join 25,000+ students today</p>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($testimonials as $story)
                        <div
                            class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full group">
                            <div class="mb-6 relative">
                                <svg class="absolute top-0 left-0 transform -translate-x-2 -translate-y-3 w-8 h-8 text-primary-100 opacity-50"
                                    fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                    <path
                                        d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                </svg>
                                <p class="text-gray-600 italic leading-relaxed relative z-10 pl-4">"{{ Str::limit($story->story, 150) }}"</p>
                            </div>

                            <div class="flex items-center gap-4 border-t border-gray-50 pt-6 mt-2">
                                <div class="relative w-10 h-10 flex-shrink-0">
                                    <img src="{{ $story->student_photo }}" alt="{{ $story->student_name }}"
                                        class="w-full h-full rounded-full object-cover border-2 border-white shadow-sm group-hover:border-primary-100 transition-colors">
                                    <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-0.5 shadow-sm">
                                        <x-dynamic-component :component="'flag-country-' . Str::lower(\App\Models\Country::where('name', $story->country)->first()?->iso_alpha2 ?? 'us')"
                                            class="w-3 h-3 rounded-full" />
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">{{ $story->student_name }}</h4>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">{{ $story->university }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">Testimonials coming soon!</p>
                </div>
            @endif
        </div>
    </section>

</div>