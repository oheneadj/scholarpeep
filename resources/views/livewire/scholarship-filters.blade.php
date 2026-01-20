<div x-data="{ showRecent: false, showSuggestions: true, showMobileFilters: false }">
    <!-- Sticky Filter Header -->
    <div
        class="sticky top-[64px] z-30 bg-white/80 backdrop-blur-xl border border-gray-100 rounded-xl shadow-sm mb-10 transition-all duration-300">
        <div class="p-4">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">

                <!-- Search -->
                <div class="relative w-full lg:w-48 xl:w-80 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" @focus="showRecent = true; showSuggestions = true"
                        @click.away="showRecent = false; showSuggestions = false" type="text"
                        placeholder="Search scholarships by keyword..."
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border-0 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary-500 text-sm font-medium transition-all placeholder-gray-400">
                </div>

                <!-- Mobile Filter Toggle -->
                <button @click="showMobileFilters = true"
                    class="lg:hidden px-4 py-3 bg-white border border-gray-200 rounded-xl flex items-center gap-2 text-sm font-bold text-gray-700 hover:text-primary-600 hover:border-primary-200 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filters
                    @php
                        $activeCount = count($selectedCountries) + count($selectedLevels) + count($selectedFields) + count($selectedTypes) + ($awardMin > 0 ? 1 : 0);
                    @endphp
                    @if($activeCount > 0)
                        <span
                            class="w-5 h-5 bg-primary-600 text-white text-[10px] rounded-full flex items-center justify-center">{{ $activeCount }}</span>
                    @endif
                </button>

                <!-- Filters Horizontal Scroll (Desktop Only) -->
                <div class="hidden lg:flex flex-1 items-center gap-2 overflow-x-auto lg:overflow-visible no-scrollbar pb-1 md:pb-0"
                    x-data="{ activeFilter: null }">

                    <!-- Country Filter -->
                    <div class="relative shrink-0">
                        <button @click="activeFilter = activeFilter === 'country' ? null : 'country'"
                            :class="activeFilter === 'country' || {{ count($selectedCountries) > 0 ? 'true' : 'false' }} ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'"
                            class="px-4 py-2.5 rounded-xl border flex items-center gap-2 text-sm font-bold transition-all">
                            <span>Locations</span>
                            @if(count($selectedCountries) > 0)
                                <div
                                    class="w-5 h-5 rounded-full bg-primary-600 text-white flex items-center justify-center text-[10px]">
                                    {{ count($selectedCountries) }}
                                </div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="activeFilter === 'country'" x-cloak @click.away="activeFilter = null"
                            x-data="{ countrySearch: '' }"
                            class="absolute top-12 left-0 w-72 bg-white rounded-xl shadow-xl border border-gray-100 p-2 z-50">
                            <div class="mb-2 px-2 pt-2">
                                <input type="text" x-model="countrySearch" placeholder="Search countries..."
                                    class="w-full px-3 py-2 text-xs bg-gray-50 rounded-lg outline-none focus:ring-2 focus:ring-primary-500/20">
                            </div>
                            <div class="max-h-64 overflow-y-auto space-y-1">
                                @foreach($countries as $country)
                                    <label
                                        class="w-full flex items-center gap-3 px-3 py-2 text-sm hover:bg-gray-50 rounded-lg cursor-pointer {{ in_array($country->slug, $selectedCountries) ? 'bg-primary-50 text-primary-700' : 'text-gray-700' }}"
                                        x-show="'{{ strtolower($country->name) }}'.includes(countrySearch.toLowerCase())">
                                        <input type="checkbox" wire:model.live="selectedCountries"
                                            value="{{ $country->slug }}"
                                            class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        <x-dynamic-component :component="'flag-country-' . $country->iso_alpha2"
                                            class="w-5 h-5 rounded-full object-cover shadow-sm" />
                                        <span class="font-medium">{{ $country->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Level Filter -->
                    <div class="relative shrink-0">
                        <button @click="activeFilter = activeFilter === 'level' ? null : 'level'"
                            :class="activeFilter === 'level' || {{ count($selectedLevels) > 0 ? 'true' : 'false' }} ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'"
                            class="px-4 py-2.5 rounded-xl border flex items-center gap-2 text-sm font-bold transition-all">
                            <span>Level</span>
                            @if(count($selectedLevels) > 0)
                                <div
                                    class="w-5 h-5 rounded-full bg-primary-600 text-white flex items-center justify-center text-[10px]">
                                    {{ count($selectedLevels) }}
                                </div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="activeFilter === 'level'" x-cloak @click.away="activeFilter = null"
                            class="absolute top-12 left-0 w-64 bg-white rounded-xl shadow-xl border border-gray-100 p-2 z-50">
                            <div class="space-y-1">
                                @foreach($educationLevels as $level)
                                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" wire:model.live="selectedLevels" value="{{ $level->slug }}"
                                            class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        <span class="text-sm font-medium text-gray-700">{{ $level->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Fields Filter -->
                    <div class="relative shrink-0">
                        <button @click="activeFilter = activeFilter === 'field' ? null : 'field'"
                            :class="activeFilter === 'field' || {{ count($selectedFields) > 0 ? 'true' : 'false' }} ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'"
                            class="px-4 py-2.5 rounded-xl border flex items-center gap-2 text-sm font-bold transition-all">
                            <span>Fields</span>
                            @if(count($selectedFields) > 0)
                                <div
                                    class="w-5 h-5 rounded-full bg-primary-600 text-white flex items-center justify-center text-[10px]">
                                    {{ count($selectedFields) }}
                                </div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="activeFilter === 'field'" x-cloak @click.away="activeFilter = null"
                            class="absolute top-12 left-0 w-80 bg-white rounded-xl shadow-xl border border-gray-100 p-2 z-50">
                            <div class="max-h-80 overflow-y-auto space-y-1">
                                @foreach($fieldsOfStudy as $parent)
                                    <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-widest mt-2">
                                        {{ $parent->name }}
                                    </div>
                                    <label
                                        class="w-full flex items-center gap-3 px-3 py-2 text-sm hover:bg-gray-50 rounded-lg cursor-pointer {{ in_array($parent->slug, $selectedFields) ? 'bg-primary-50 text-primary-700 font-bold' : 'text-gray-700' }}">
                                        <input type="checkbox" wire:model.live="selectedFields" value="{{ $parent->slug }}"
                                            class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        <span>{{ $parent->name }} (All)</span>
                                    </label>
                                    @foreach($parent->children as $child)
                                        <label
                                            class="w-full flex items-center gap-3 px-5 py-2 text-sm hover:bg-gray-50 rounded-lg cursor-pointer {{ in_array($child->slug, $selectedFields) ? 'bg-primary-50 text-primary-700 font-bold' : 'text-gray-700' }}">
                                            <input type="checkbox" wire:model.live="selectedFields" value="{{ $child->slug }}"
                                                class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                            <span>{{ $child->name }}</span>
                                        </label>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Award Filter -->
                    <div class="relative shrink-0" x-data="{ min: @entangle('awardMin') }">
                        <button @click="activeFilter = activeFilter === 'award' ? null : 'award'"
                            :class="activeFilter === 'award' || min > 0 ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'"
                            class="px-4 py-2.5 rounded-xl border flex items-center gap-2 text-sm font-bold transition-all">
                            <span>Amount</span>
                            <template x-if="min > 0">
                                <span class="bg-primary-600 text-white text-[10px] px-1.5 py-0.5 rounded-full"
                                    x-text="'$'+parseInt(min/1000)+'k+'"></span>
                            </template>
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="activeFilter === 'award'" x-cloak @click.away="activeFilter = null"
                            class="absolute top-12 left-0 w-72 bg-white rounded-xl shadow-xl border border-gray-100 p-6 z-50">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Min
                                Award Amount</label>
                            <input type="range" min="0" max="50000" step="1000" x-model="min"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary-600">
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-xs font-bold text-gray-400">$0</span>
                                <div
                                    class="px-3 py-1 bg-primary-50 text-primary-700 rounded-lg text-xs font-bold border border-primary-100">
                                    $<span x-text="parseInt(min).toLocaleString()"></span>+
                                </div>
                                <span class="text-xs font-bold text-gray-400">$50k+</span>
                            </div>
                        </div>
                    </div>

                    <!-- Type Filter -->
                    <div class="relative shrink-0">
                        <button @click="activeFilter = activeFilter === 'type' ? null : 'type'"
                            :class="activeFilter === 'type' || {{ count($selectedTypes) > 0 ? 'true' : 'false' }} ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-white text-gray-700 border-gray-200 hover:border-gray-300'"
                            class="px-4 py-2.5 rounded-xl border flex items-center gap-2 text-sm font-bold transition-all">
                            <span>Type</span>
                            @if(count($selectedTypes) > 0)
                                <div
                                    class="w-5 h-5 rounded-full bg-primary-600 text-white flex items-center justify-center text-[10px]">
                                    {{ count($selectedTypes) }}
                                </div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="activeFilter === 'type'" x-cloak @click.away="activeFilter = null"
                            class="absolute top-12 left-0 w-64 bg-white rounded-xl shadow-xl border border-gray-100 p-3 z-50">
                            <div class="space-y-1">
                                @foreach($scholarshipTypes as $type)
                                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" wire:model.live="selectedTypes" value="{{ $type->slug }}"
                                            class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        <span class="text-sm font-medium text-gray-700">{{ $type->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="w-px h-8 bg-gray-100 mx-2"></div>

                    <!-- Reset -->
                    <button wire:click="resetFilters" @click="activeFilter = null"
                        class="px-4 py-2.5 rounded-xl border border-dashed border-gray-300 text-xs font-bold text-gray-500 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-all uppercase tracking-wider shrink-0">
                        Reset
                    </button>

                    <!-- Save Search -->
                    @auth
                        @php
                            $hasFilters = count($selectedCountries) > 0 || count($selectedLevels) > 0 || count($selectedFields) > 0 || count($selectedTypes) > 0 || $search || $awardMin > 0;
                        @endphp
                        @if($hasFilters)
                            <button wire:click="$set('showSaveModal', true)"
                                class="px-4 py-2.5 rounded-xl border border-primary-100 bg-primary-50 text-xs font-bold text-primary-600 hover:bg-primary-100 transition-all uppercase tracking-wider shrink-0 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                Save
                            </button>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Active Filter Tags --}}
            @php
                $activeFilters = count($selectedCountries) > 0 || count($selectedLevels) > 0 || count($selectedFields) > 0 || count($selectedTypes) > 0 || $search || $awardMin > 0;
            @endphp
            @if($activeFilters)
                <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-50">
                    @if($search)
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-700 rounded-lg text-xs font-bold border border-gray-100">
                            Keyword: {{ $search }}
                            <button wire:click="$set('search', '')" class="text-gray-400 hover:text-red-500"><svg
                                    class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg></button>
                        </span>
                    @endif

                    @foreach($selectedCountries as $sSlug)
                        @php $sCountry = $countries->where('slug', $sSlug)->first(); @endphp
                        @if($sCountry)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary-50 text-primary-700 rounded-lg text-xs font-bold border border-primary-100">
                                {{ $sCountry->name }}
                                <button
                                    wire:click="$set('selectedCountries', {{ json_encode(array_values(array_diff($selectedCountries, [$sSlug]))) }})"
                                    class="text-primary-400 hover:text-red-500"><svg class="w-3 h-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg></button>
                            </span>
                        @endif
                    @endforeach

                    @foreach($selectedLevels as $sSlug)
                        @php $sLevel = $educationLevels->where('slug', $sSlug)->first(); @endphp
                        @if($sLevel)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary-50 text-primary-700 rounded-lg text-xs font-bold border border-primary-100">
                                {{ $sLevel->name }}
                                <button
                                    wire:click="$set('selectedLevels', {{ json_encode(array_values(array_diff($selectedLevels, [$sSlug]))) }})"
                                    class="text-primary-400 hover:text-red-500"><svg class="w-3 h-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg></button>
                            </span>
                        @endif
                    @endforeach

                    @if($awardMin > 0)
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-bold border border-green-100">
                            Min: ${{ number_format($awardMin) }}
                            <button wire:click="$set('awardMin', 0)" class="text-green-400 hover:text-red-500"><svg
                                    class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg></button>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Mobile Filter Drawer -->
    <div x-show="showMobileFilters" class="relative z-50 lg:hidden" aria-labelledby="slide-over-title" role="dialog"
        aria-modal="true" style="display: none;">
        <div x-show="showMobileFilters" x-transition:enter="ease-in-out duration-500"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
            @click="showMobileFilters = false"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div x-show="showMobileFilters"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                        class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                            <div class="px-4 py-6 sm:px-6 border-b border-gray-100 flex items-center justify-between">
                                <h2 class="text-lg font-bold text-gray-900" id="slide-over-title">Filters</h2>
                                <button type="button" @click="showMobileFilters = false"
                                    class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="relative flex-1 px-4 py-6 sm:px-6 space-y-8">
                                <!-- Mobile Search -->
                                <div>
                                    <label class="text-sm font-bold text-gray-900 block mb-2">Keywords</label>
                                    <input wire:model.live.debounce.300ms="search" type="text"
                                        placeholder="Search keywords..."
                                        class="w-full bg-gray-50 border-gray-200 rounded-lg text-sm px-4 py-2 focus:ring-primary-500 focus:border-primary-500">
                                </div>

                                <!-- Mobile Locations -->
                                <div>
                                    <label class="text-sm font-bold text-gray-900 block mb-3">Locations</label>
                                    <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                        @foreach($countries as $country)
                                            <label
                                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                <input type="checkbox" wire:model.live="selectedCountries"
                                                    value="{{ $country->slug }}"
                                                    class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                                <x-dynamic-component :component="'flag-country-' . $country->iso_alpha2"
                                                    class="w-5 h-5 rounded-full object-cover shadow-sm" />
                                                <span class="text-sm text-gray-700">{{ $country->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Mobile Level -->
                                <div>
                                    <label class="text-sm font-bold text-gray-900 block mb-3">Education Level</label>
                                    <div class="space-y-2">
                                        @foreach($educationLevels as $level)
                                            <label
                                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                <input type="checkbox" wire:model.live="selectedLevels"
                                                    value="{{ $level->slug }}"
                                                    class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                                <span class="text-sm text-gray-700">{{ $level->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Mobile Fields -->
                                <div>
                                    <label class="text-sm font-bold text-gray-900 block mb-3">Field of Study</label>
                                    <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                        @foreach($fieldsOfStudy as $parent)
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-2 px-2">
                                                {{ $parent->name }}
                                            </p>
                                            <label
                                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                <input type="checkbox" wire:model.live="selectedFields"
                                                    value="{{ $parent->slug }}"
                                                    class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                                <span class="text-sm text-gray-700">All {{ $parent->name }}</span>
                                            </label>
                                            @foreach($parent->children as $child)
                                                <label
                                                    class="flex items-center gap-3 p-2 pl-6 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                    <input type="checkbox" wire:model.live="selectedFields"
                                                        value="{{ $child->slug }}"
                                                        class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                                    <span class="text-sm text-gray-700">{{ $child->name }}</span>
                                                </label>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Mobile Amount -->
                                <div x-data="{ min: @entangle('awardMin') }">
                                    <label class="text-sm font-bold text-gray-900 block mb-3 flex justify-between">
                                        <span>Min Award</span>
                                        <span class="text-primary-600"
                                            x-text="'$'+parseInt(min).toLocaleString()"></span>
                                    </label>
                                    <input type="range" min="0" max="50000" step="1000" x-model="min"
                                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary-600">
                                    <div class="flex justify-between text-xs text-gray-400 font-bold mt-2">
                                        <span>$0</span>
                                        <span>$50k+</span>
                                    </div>
                                </div>

                                <!-- Mobile Types -->
                                <div>
                                    <label class="text-sm font-bold text-gray-900 block mb-3">Scholarship Type</label>
                                    <div class="space-y-2">
                                        @foreach($scholarshipTypes as $type)
                                            <label
                                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                <input type="checkbox" wire:model.live="selectedTypes"
                                                    value="{{ $type->slug }}"
                                                    class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                                <span class="text-sm text-gray-700">{{ $type->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 px-4 py-6 sm:px-6">
                                <button wire:click="resetFilters" @click="showMobileFilters = false"
                                    class="w-full flex justify-center items-center px-4 py-3 border border-gray-200 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50">
                                    Reset Filters
                                </button>
                                <button @click="showMobileFilters = false"
                                    class="mt-3 w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary-600 hover:bg-primary-700">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Search Modal -->
    @auth
        <div x-data="{ show: @entangle('showSaveModal') }" x-show="show" x-cloak
            class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    @click="show = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="show" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Save this Search
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-4">
                                    Give your search a name to easily find it later.
                                </p>
                                <input type="text" wire:model="searchName"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                    placeholder="e.g. Masters in UK">
                                @error('searchName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="saveSearch"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button type="button" @click="show = false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endauth
</div>