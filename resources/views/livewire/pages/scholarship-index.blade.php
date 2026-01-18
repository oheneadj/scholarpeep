<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen" x-data="{ showRecent: false, showSuggestions: true }">
    
    <!-- Sticky Filter Header -->
    <div class="sticky top-[64px] z-30 bg-white/80 backdrop-blur-xl border border-gray-100 rounded-xl shadow-sm mb-10 transition-all duration-300">
        <div class="p-4">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                
                <!-- Search -->
                <div class="relative w-full lg:w-48 xl:w-80 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        wire:model.live.debounce.300ms="search" 
                        @focus="showRecent = true; showSuggestions = true"
                        @click.away="showRecent = false; showSuggestions = false"
                        type="text" 
                        placeholder="Search scholarships by keyword..."
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border-0 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary-500 text-sm font-medium transition-all placeholder-gray-400">
                    
                    <!-- Search Suggestions (Absolute) -->
                    @if($search && count($suggestions) > 0)
                        <div x-show="showSuggestions" class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden py-2 top-full">
                            <p class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Suggestions</p>
                            @foreach($suggestions as $suggestion)
                                <button 
                                    @if($suggestion['type'] === 'field') wire:click="$set('selectedField', '{{ $suggestion['value'] }}'); $set('search', '');" 
                                    @else wire:click="$set('selectedCountry', '{{ $suggestion['value'] }}'); $set('search', '');" @endif
                                    class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center gap-3 transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center text-primary-600">
                                        @if($suggestion['type'] === 'field') <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg> @else <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg> @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">{{ $suggestion['label'] }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase font-bold">{{ $suggestion['type'] }}</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Filters Horizontal Scroll -->
                <div class="flex-1 flex items-center gap-2 overflow-x-auto lg:overflow-visible no-scrollbar pb-1 md:pb-0" x-data="{ activeFilter: null }">
                    
                    <!-- Country Filter -->
                    <div class="relative shrink-0">
                        <button @click="activeFilter = activeFilter === 'country' ? null : 'country'" :class="activeFilter === 'country' || '{{ $selectedCountry }}' ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'" class="px-4 py-2.5 rounded-xl border flex items-center gap-2 text-sm font-bold transition-all">
                            <span>Locations</span>
                            @if($selectedCountry)
                                <div class="w-5 h-5 rounded-full bg-primary-600 text-white flex items-center justify-center text-[10px]">1</div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>

                        <div x-show="activeFilter === 'country'" x-cloak @click.away="activeFilter = null" x-data="{ countrySearch: '' }" class="absolute top-12 left-0 w-72 bg-white rounded-xl shadow-xl border border-gray-100 p-2 z-50">
                            <div class="mb-2 px-2 pt-2">
                                <input type="text" x-model="countrySearch" placeholder="Search countries..." class="w-full px-3 py-2 text-xs bg-gray-50 rounded-lg outline-none focus:ring-2 focus:ring-primary-500/20">
                            </div>
                            <div class="max-h-64 overflow-y-auto space-y-1">
                                <button wire:click="$set('selectedCountry', '')" x-show="'all countries'.includes(countrySearch.toLowerCase())" @click="activeFilter = null" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 rounded-lg text-gray-600 font-medium {{ !$selectedCountry ? 'bg-primary-50 text-primary-700' : '' }}">All Countries</button>
                                @foreach($countries as $country)
                                    <button wire:click="$set('selectedCountry', '{{ $country->slug }}')" x-show="'{{ strtolower($country->name) }}'.includes(countrySearch.toLowerCase())" @click="activeFilter = null" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 rounded-lg flex items-center gap-3 {{ $selectedCountry === $country->slug ? 'bg-primary-50 text-primary-700' : 'text-gray-700' }}">
                                        <x-dynamic-component :component="'flag-country-' . $country->iso_alpha2" class="w-5 h-5 rounded-full object-cover shadow-sm" />
                                        <span class="font-medium">{{ $country->name }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Level Filter -->
                    <div class="relative shrink-0">
                        <button @click="activeFilter = activeFilter === 'level' ? null : 'level'" :class="activeFilter === 'level' || '{{ $selectedLevel }}' ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'" class="px-4 py-2.5 rounded-xl border flex items-center gap-2 text-sm font-bold transition-all">
                            <span>Level</span>
                            @if($selectedLevel)
                                <div class="w-5 h-5 rounded-full bg-primary-600 text-white flex items-center justify-center text-[10px]">1</div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        
                        <div x-show="activeFilter === 'level'" x-cloak @click.away="activeFilter = null" class="absolute top-12 left-0 w-64 bg-white rounded-xl shadow-xl border border-gray-100 p-2 z-50">
                            <div class="space-y-1">
                                <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" wire:model.live="selectedLevel" value="" class="text-primary-600 focus:ring-primary-500 border-gray-300">
                                    <span class="text-sm font-medium text-gray-700">All Levels</span>
                                </label>
                                @foreach($educationLevels as $level)
                                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer" @click="activeFilter = null">
                                        <input type="radio" wire:model.live="selectedLevel" value="{{ $level->slug }}" class="text-primary-600 focus:ring-primary-500 border-gray-300">
                                        <span class="text-sm font-medium text-gray-700">{{ $level->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Fields Filter -->
                    <div class="relative shrink-0">
                        <button @click="activeFilter = activeFilter === 'field' ? null : 'field'" :class="activeFilter === 'field' || '{{ $selectedField }}' ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'" class="px-4 py-2.5 rounded-xl border flex items-center gap-2 text-sm font-bold transition-all">
                            <span>Fields</span>
                            @if($selectedField)
                                <div class="w-5 h-5 rounded-full bg-primary-600 text-white flex items-center justify-center text-[10px]">1</div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        
                        <div x-show="activeFilter === 'field'" x-cloak @click.away="activeFilter = null" class="absolute top-12 left-0 w-80 bg-white rounded-xl shadow-xl border border-gray-100 p-2 z-50">
                            <div class="max-h-80 overflow-y-auto space-y-1">
                                <button wire:click="$set('selectedField', '')" @click="activeFilter = null" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 rounded-lg text-gray-600 font-medium">All Fields</button>
                                @foreach($fieldsOfStudy as $parent)
                                    <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-widest mt-2">{{ $parent->name }}</div>
                                    <button wire:click="$set('selectedField', '{{ $parent->slug }}')" @click="activeFilter = null" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 rounded-lg flex items-center gap-2 {{ $selectedField === $parent->slug ? 'bg-primary-50 text-primary-700 font-bold' : 'text-gray-700' }}">
                                        <span>{{ $parent->name }} (All)</span>
                                    </button>
                                    @foreach($parent->children as $child)
                                        <button wire:click="$set('selectedField', '{{ $child->slug }}')" @click="activeFilter = null" class="w-full text-left px-5 py-2 text-sm hover:bg-gray-50 rounded-lg flex items-center gap-2 {{ $selectedField === $child->slug ? 'bg-primary-50 text-primary-700 font-bold' : 'text-gray-700' }}">
                                            <span>{{ $child->name }}</span>
                                        </button>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Award Filter -->
                    <div class="relative shrink-0" x-data="{ min: @entangle('awardMin') }">
                        <button @click="activeFilter = activeFilter === 'award' ? null : 'award'" :class="activeFilter === 'award' || min > 0 ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'" class="px-4 py-2.5 rounded-xl border flex items-center gap-2 text-sm font-bold transition-all">
                            <span>Amount</span>
                             <template x-if="min > 0">
                                <span class="bg-primary-600 text-white text-[10px] px-1.5 py-0.5 rounded-full" x-text="'$'+parseInt(min/1000)+'k+'"></span>
                            </template>
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>

                         <div x-show="activeFilter === 'award'" x-cloak @click.away="activeFilter = null" class="absolute top-12 left-0 w-72 bg-white rounded-xl shadow-xl border border-gray-100 p-6 z-50">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Min Award Amount</label>
                            <input type="range" min="0" max="50000" step="1000" x-model="min" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary-600">
                             <div class="flex justify-between items-center mt-3">
                                <span class="text-xs font-bold text-gray-400">$0</span>
                                <div class="px-3 py-1 bg-primary-50 text-primary-700 rounded-lg text-xs font-bold border border-primary-100">
                                    $<span x-text="parseInt(min).toLocaleString()"></span>+
                                </div>
                                <span class="text-xs font-bold text-gray-400">$50k+</span>
                            </div>
                        </div>
                    </div>

                    <!-- Type Filter -->
                    <div class="relative shrink-0">
                        <button @click="activeFilter = activeFilter === 'type' ? null : 'type'" :class="activeFilter === 'type' || {{ count($selectedTypes) > 0 ? 'true' : 'false' }} ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'" class="px-4 py-2.5 rounded-xl border flex items-center gap-2 text-sm font-bold transition-all">
                            <span>Type</span>
                            @if(count($selectedTypes) > 0)
                                <div class="w-5 h-5 rounded-full bg-primary-600 text-white flex items-center justify-center text-[10px]">{{ count($selectedTypes) }}</div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>

                        <div x-show="activeFilter === 'type'" x-cloak @click.away="activeFilter = null" class="absolute top-12 left-0 w-64 bg-white rounded-xl shadow-xl border border-gray-100 p-3 z-50">
                            <div class="space-y-1">
                               @foreach($scholarshipTypes as $type)
                                <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" wire:model.live="selectedTypes" value="{{ $type->slug }}" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    <span class="text-sm font-medium text-gray-700">{{ $type->name }}</span>
                                </label>
                            @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-px h-8 bg-gray-100 mx-2"></div>

                    <!-- Reset -->
                     <button
                        wire:click="resetFilters"
                        @click="activeFilter = null"
                        class="px-4 py-2.5 rounded-xl border border-dashed border-gray-300 text-xs font-bold text-gray-500 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-all uppercase tracking-wider shrink-0">
                        Reset
                    </button>
                    

                     <!-- View Toggle + Sort (Desktop) -->
                    <div class="hidden lg:flex items-center gap-4 shrink-0">
                         <select wire:model.live="sortBy" class="text-sm font-bold text-gray-700 bg-transparent border-none focus:ring-0 cursor-pointer hover:text-primary-600 transition-colors">
                            <option value="relevance">Recommended</option>
                            <option value="deadline">Nearest Deadline</option>
                            <option value="award_high">Highest Award</option>
                            <option value="newest">Recently Added</option>
                        </select>
                        <div class="flex bg-gray-100 rounded-lg p-1">
                             <button wire:click="$set('viewMode', 'grid')" class="p-1.5 rounded-md transition-all {{ $viewMode === 'grid' ? 'bg-white shadow text-primary-600' : 'text-gray-400 hover:text-gray-600' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            </button>
                            <button wire:click="$set('viewMode', 'list')" class="p-1.5 rounded-md transition-all {{ $viewMode === 'list' ? 'bg-white shadow text-primary-600' : 'text-gray-400 hover:text-gray-600' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats & Sort Mobile -->
    <div class="flex flex-col md:flex-row justify-between items-baseline md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold font-display text-gray-900 mb-1">Discovery</h1>
            <p class="text-sm font-medium text-gray-500">Showing <span class="text-gray-900 font-bold">{{ $scholarships->count() }}</span> of <span class="text-gray-900 font-bold">{{ $scholarships->total() }}</span> scholarships</p>
        </div>
        <!-- Mobile Sort -->
        <div class="flex lg:hidden items-center gap-3">
             <select wire:model.live="sortBy" class="text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-lg py-2 pl-3 pr-8 focus:ring-primary-500 focus:border-primary-500">
                <option value="relevance">Recommended</option>
                <option value="deadline">Deadline</option>
                <option value="award_high">Highest Award</option>
                <option value="newest">Newest</option>
            </select>
        </div>
    </div>

    <!-- Premium Section -->
    @if($premiumScholarships->count() > 0 && $scholarships->onFirstPage())
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-px flex-1 bg-purple-100"></div>
                <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-purple-500 bg-purple-50 px-4 py-1.5 rounded-full border border-purple-100 flex items-center gap-2">
                    <svg class="w-3 h-3 text-purple-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    Premium Sponsored
                </h2>
                <div class="h-px flex-1 bg-purple-100"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($premiumScholarships as $premium)
                    <x-scholarship-card :scholarship="$premium" view="grid" class="border-2 border-purple-500 shadow-xl shadow-purple-600/10" wire:key="premium-{{ $premium->id }}" />
                @endforeach
            </div>
        </div>
    @endif

    <!-- Main Results Section -->
    @if($scholarships->count() > 0)
        <div class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-4' }}">
            @foreach($scholarships as $scholarship)
                <x-scholarship-card :scholarship="$scholarship" :view="$viewMode" wire:key="scholarship-card-{{ $scholarship->id }}-{{ $loop->index }}" />
            @endforeach
        </div>

        @if($scholarships->hasMorePages())
            <div class="mt-16 text-center">
                <button wire:click="loadMore" wire:loading.attr="disabled" class="px-10 py-3 bg-white border border-gray-200 text-gray-900 font-bold rounded-full hover:bg-gray-50 hover:border-primary-200 shadow-sm transition-all active:scale-95 flex items-center gap-2 mx-auto disabled:opacity-50">
                    <span wire:loading.remove>Load More</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-primary-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Loading...
                    </span>
                </button>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200 p-16 text-center">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-gray-300 mx-auto mb-6 shadow-sm">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No scholarships found</h3>
            <p class="text-gray-500 mb-8 max-w-sm mx-auto">We couldn't find any results matching your filters. Try adjusting your criteria.</p>
            <button wire:click="resetFilters" class="px-8 py-3 bg-white text-primary-600 border border-gray-200 rounded-full font-bold hover:bg-primary-50 hover:border-primary-200 transition-all shadow-sm">
                Clear Filters
            </button>
        </div>
    @endif
</div>