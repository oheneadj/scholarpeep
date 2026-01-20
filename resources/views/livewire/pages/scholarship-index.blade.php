<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">

    <!-- Modular Filters -->
    <livewire:scholarship-filters />

    <!-- Stats & Sort Mobile -->
    <div class="flex flex-col md:flex-row justify-between items-baseline md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold font-display text-gray-900 mb-1">Discovery</h1>
            <p class="text-sm font-medium text-gray-500">Showing <span
                    class="text-gray-900 font-bold">{{ $scholarships->count() }}</span> of <span
                    class="text-gray-900 font-bold">{{ $scholarships->total() }}</span> scholarships</p>
        </div>
        <!-- Mobile Sort -->
        <div class="flex lg:hidden items-center gap-3">
            <select wire:model.live="sortBy"
                class="text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-lg py-2 pl-3 pr-8 focus:ring-primary-500 focus:border-primary-500">
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
                <h2
                    class="text-[10px] font-black uppercase tracking-[0.3em] text-purple-500 bg-purple-50 px-4 py-1.5 rounded-full border border-purple-100 flex items-center gap-2">
                    <svg class="w-3 h-3 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                    Premium Sponsored
                </h2>
                <div class="h-px flex-1 bg-purple-100"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($premiumScholarships as $premium)
                    <x-scholarship-card :scholarship="$premium" view="grid"
                        class="border-2 border-purple-500 shadow-xl shadow-purple-600/10"
                        wire:key="premium-{{ $premium->id }}" />
                @endforeach
            </div>
        </div>
    @endif

    <!-- Main Results Section -->
    @if($scholarships->count() > 0)
        <div class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-4' }}">
            @foreach($scholarships as $scholarship)
                <x-scholarship-card :scholarship="$scholarship" :view="$viewMode"
                    wire:key="scholarship-card-{{ $scholarship->id }}-{{ $loop->index }}" />
            @endforeach
        </div>

        @if($scholarships->hasMorePages())
            <div class="mt-16 text-center">
                <button wire:click="loadMore" wire:loading.attr="disabled"
                    class="px-10 py-3 bg-white border border-gray-200 text-gray-900 font-bold rounded-full hover:bg-gray-50 hover:border-primary-200 shadow-sm transition-all active:scale-95 flex items-center gap-2 mx-auto disabled:opacity-50">
                    <span wire:loading.remove>Load More</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-primary-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Loading...
                    </span>
                </button>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200 p-16 text-center">
            <div
                class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-gray-300 mx-auto mb-6 shadow-sm">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No scholarships found</h3>
            <p class="text-gray-500 mb-8 max-w-sm mx-auto">We couldn't find any results matching your filters. Try adjusting
                your criteria.</p>
            <button wire:click="resetFilters"
                class="px-8 py-3 bg-white text-primary-600 border border-gray-200 rounded-full font-bold hover:bg-primary-50 hover:border-primary-200 transition-all shadow-sm">
                Clear Filters
            </button>
        </div>
    @endif

    <!-- Mobile Filter Drawer -->
</div>