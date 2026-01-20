<div class="min-h-screen flex flex-col">
    <!-- Header/Nav will be included via layout -->

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-primary-600 to-primary-700 text-white border-b border-primary-800/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="max-w-3xl">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="px-3 py-1 bg-white/10 backdrop-blur-sm rounded-full text-[10px] font-bold uppercase tracking-widest border border-white/10">Free Resources</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight tracking-tight">
                    Educational <span class="bg-clip-text text-transparent bg-gradient-to-r from-white to-primary-200">Resources</span>
                </h1>
                <p class="text-lg md:text-xl text-primary-50 leading-relaxed font-medium">
                    Discover guides, templates, tools, and more to help you succeed in your scholarship journey.
                    @guest
                        <span class="block mt-4 text-white font-bold bg-white/10 border border-white/20 px-4 py-2 rounded-xl inline-block">Create a free account to access all resources!</span>
                    @endguest
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <!-- Clean Filter Sidebar -->
                <aside class="lg:col-span-3">
                    <div class="lg:sticky lg:top-24 space-y-8">

                        <!-- Filter Header -->
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-2">Filters</h2>
                            <p class="text-sm text-gray-500 font-medium">{{ $resources->total() }} resources available</p>
                        </div>

                        <!-- Resource Type Pills -->
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Type</h3>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $typeConfig = [
                                        'guide' => ['color' => 'blue', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                                        'template' => ['color' => 'purple', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                        'tool' => ['color' => 'emerald', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                                        'video' => ['color' => 'rose', 'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
                                        'article' => ['color' => 'amber', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
                                        'calculator' => ['color' => 'indigo', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                                    ];
                                @endphp
                                @foreach($resourceTypes as $type)
                                    @php $config = $typeConfig[$type] ?? ['color' => 'gray', 'icon' => '']; @endphp
                                    <button wire:click="filterByType('{{ $type }}')"
                                        class="group inline-flex items-center gap-2 px-4 py-2 rounded-2xl border transition-all duration-200 {{ $selectedType === $type ? 'bg-primary-600 border-primary-600 text-white shadow-lg shadow-primary-200' : 'bg-white border-gray-100 text-gray-600 hover:border-primary-100 hover:bg-primary-50/30' }}">
                                        @if(isset($config['icon']))
                                            <svg class="w-4 h-4 {{ $selectedType === $type ? 'text-white' : 'text-gray-400 group-hover:text-primary-500' }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $config['icon'] }}" />
                                            </svg>
                                        @endif
                                        <span class="text-xs font-bold uppercase tracking-wider capitalize">{{ $type }}</span>
                                    </button>
                                @endforeach
                            </div>

                            @if($selectedType)
                                <button wire:click="resetFilters"
                                    class="text-xs text-primary-600 hover:text-primary-700 font-bold uppercase tracking-widest flex items-center gap-1.5 group transition-colors">
                                    <svg class="w-3.5 h-3.5 group-hover:rotate-90 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Clear Type
                                </button>
                            @endif
                        </div>

                        <!-- Divider -->
                        <div class="h-px bg-gray-100"></div>

                        <!-- Search Section -->
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Search</h3>

                            <div class="relative group">
                                <input type="text" wire:model.live.debounce.300ms="search"
                                    placeholder="Search resources..."
                                    class="w-full pl-11 pr-4 py-3.5 bg-white border border-gray-100 rounded-2xl focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 focus:bg-white transition-all text-sm font-medium">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Card -->
                        <div
                            class="bg-gradient-to-br from-primary-50 to-white rounded-2xl p-6 border border-primary-100 shadow-sm">
                            <div class="flex items-center gap-4 mb-3">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-gray-900 leading-none">{{ $resources->total() }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">
                                        {{ Str::plural('Resource', $resources->total()) }}
                                    </p>
                                </div>
                            </div>
                            @guest
                                <div class="mt-4 pt-4 border-t border-primary-100/50">
                                    <p class="text-[10px] text-primary-600 font-bold uppercase tracking-widest mb-3">🔒 Unlock Premium Content</p>
                                    <a href="{{ route('register') }}"
                                        class="block text-center px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-2xl text-xs font-bold uppercase tracking-widest transition-all shadow-md shadow-primary-200 active:scale-95">
                                        Create Free Account
                                    </a>
                                </div>
                            @endguest
                        </div>
                    </div>
                </aside>

                <!-- Resources Grid -->
                <main class="lg:col-span-9">
                    <!-- Results Header -->
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-1">
                                @if($search || $selectedType)
                                    Filtered Results
                                @else
                                    All Resources
                                @endif
                            </h2>
                            <p class="text-sm text-gray-500 font-medium">
                                Showing {{ $resources->count() }} of {{ $resources->total() }} results
                            </p>
                        </div>
                    </div>

                    <!-- Resources Grid -->
                    @if($resources->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                            @foreach($resources as $resource)
                                <x-resource-card :resource="$resource" :is-saved="in_array($resource->id, $savedResourceIds)" />
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-16 pt-10 border-t border-gray-100 flex flex-col items-center gap-6">
                            <div class="flex items-center gap-2">
                                {{-- Previous Page --}}
                                @if ($resources->onFirstPage())
                                    <span class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-300 cursor-not-allowed border border-gray-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </span>
                                @else
                                    <button wire:click="previousPage" 
                                            class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-600 hover:text-primary-600 hover:border-primary-200 hover:bg-primary-50 transition shadow-sm active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                @endif

                                {{-- Page Numbers --}}
                                <div class="flex items-center gap-2">
                                    @for ($page = 1; $page <= $resources->lastPage(); $page++)
                                        @if ($page == $resources->currentPage())
                                            <span class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center text-sm font-bold text-white shadow-lg shadow-primary-200">{{ $page }}</span>
                                        @else
                                            <button wire:click="gotoPage({{ $page }})" 
                                                    class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-sm font-bold text-gray-600 hover:text-primary-600 hover:border-primary-100 hover:bg-primary-50/30 transition shadow-sm active:scale-95">
                                                {{ $page }}
                                            </button>
                                        @endif
                                    @endfor
                                </div>

                                {{-- Next Page --}}
                                @if ($resources->hasMorePages())
                                    <button wire:click="nextPage" 
                                            class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-600 hover:text-primary-600 hover:border-primary-200 hover:bg-primary-50 transition shadow-sm active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                @else
                                    <span class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-300 cursor-not-allowed border border-gray-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                showing {{ ($resources->currentPage()-1)*$resources->perPage()+1 }} to {{ min($resources->currentPage()*$resources->perPage(), $resources->total()) }} of {{ $resources->total() }} results
                            </p>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-50 text-gray-300 mb-6">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No resources found</h3>
                            <p class="text-gray-500 font-medium mb-8">Try adjusting your filters or search query.</p>
                            @if($search || $selectedType)
                                <button wire:click="resetFilters"
                                    class="px-8 py-4 bg-primary-600 text-white rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-primary-700 shadow-lg shadow-primary-200 transition-all active:scale-95">
                                    Clear All Filters
                                </button>
                            @endif
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>

    <!-- Footer will be included via layout -->
</div>