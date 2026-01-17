<div class="min-h-screen flex flex-col">
    <!-- Header/Nav will be included via layout -->

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-primary-600 via-primary-700 to-purple-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="max-w-3xl">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-bold">Free
                        Resources</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black font-display mb-6 leading-tight">
                    Educational Resources
                </h1>
                <p class="text-lg md:text-xl text-primary-100 leading-relaxed">
                    Discover guides, templates, tools, and more to help you succeed in your scholarship journey.
                    @guest
                        <span class="font-bold text-white">Create a free account to access all resources!</span>
                    @endguest
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Clean Filter Sidebar -->
                <aside class="lg:col-span-3">
                    <div class="lg:sticky lg:top-24 space-y-6">

                        <!-- Filter Header -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 mb-1">Filter by category</h2>
                            <p class="text-sm text-gray-500">{{ $resources->total() }} resources discovered</p>
                        </div>

                        <!-- Resource Type Pills -->
                        <div>
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
                                        class="group inline-flex items-center gap-2 px-3 py-2 rounded-xl border transition-all duration-200 {{ $selectedType === $type ? 'bg-gray-900 border-gray-900 text-white shadow-md transform scale-105' : 'bg-white border-gray-200 text-gray-600 hover:border-gray-300 hover:bg-gray-50' }}">
                                        @if(isset($config['icon']))
                                            <svg class="w-4 h-4 {{ $selectedType === $type ? 'text-white' : 'text-gray-400 group-hover:text-gray-600' }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $config['icon'] }}" />
                                            </svg>
                                        @endif
                                        <span class="text-sm font-semibold capitalize">{{ $type }}</span>
                                    </button>
                                @endforeach
                            </div>

                            @if($selectedType)
                                <button wire:click="resetFilters"
                                    class="mt-3 text-xs text-gray-500 hover:text-gray-900 font-medium flex items-center gap-1 group">
                                    <svg class="w-3 h-3 group-hover:rotate-180 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Clear filter
                                </button>
                            @endif
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Search Section -->
                        <div>
                            <h3 class="text-base font-bold text-gray-900 mb-3">Refine results</h3>
                            <p class="text-xs text-gray-500 mb-4">Search by keyword</p>

                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="search"
                                    placeholder="Search resources..."
                                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all text-sm">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <!-- Active Search Pills -->
                            @if($search)
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                                        {{ $search }}
                                        <button wire:click="$set('search', '')" class="hover:text-gray-900">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            @endif

                            @if($search || $selectedType)
                                <button wire:click="resetFilters"
                                    class="mt-4 w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                    Clear All
                                </button>
                            @endif
                        </div>

                        <!-- Stats Card -->
                        <div
                            class="bg-gradient-to-br from-primary-50 to-purple-50 rounded-2xl p-6 border border-primary-100">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-black text-primary-700">{{ $resources->total() }}</p>
                                    <p class="text-xs text-primary-600 font-medium">
                                        {{ Str::plural('Resource', $resources->total()) }}
                                    </p>
                                </div>
                            </div>
                            @guest
                                <div class="mt-4 pt-4 border-t border-primary-200">
                                    <p class="text-xs text-primary-700 font-medium mb-2">🔒 Sign up to unlock all resources
                                    </p>
                                    <a href="{{ route('register') }}"
                                        class="block text-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-bold transition-colors">
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
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                                @if($search || $selectedType)
                                    Filtered Results
                                @else
                                    All Resources
                                @endif
                            </h2>
                            <p class="text-sm text-gray-600">
                                Showing {{ $resources->count() }} of {{ $resources->total() }}
                                {{ Str::plural('resource', $resources->total()) }}
                            </p>
                        </div>
                    </div>

                    <!-- Resources Grid -->
                    @if($resources->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6 mb-12">
                            @foreach($resources as $resource)
                                <x-resource-card :resource="$resource" :is-saved="in_array($resource->id, $savedResourceIds)" />
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $resources->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-20">
                            <div
                                class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">No resources found</h3>
                            <p class="text-gray-600 mb-8">Try adjusting your filters or search query.</p>
                            @if($search || $selectedType)
                                <button wire:click="resetFilters"
                                    class="px-6 py-3 bg-primary-600 text-white rounded-xl font-bold hover:bg-primary-700 shadow-lg hover:shadow-xl transition-all">
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