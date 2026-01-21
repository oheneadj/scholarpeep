<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- High-End Header Section --}}
    <div class="mb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-8 border-b border-gray-100">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-12 h-12 bg-primary-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-primary-600/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                    <span
                        class="px-3 py-1 bg-primary-50 text-primary-600 text-[10px] font-black uppercase tracking-widest rounded-full">Personal
                        Library</span>
                </div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight font-display mb-2">Saved Resources</h1>
                <p class="text-gray-500 font-medium text-lg">Your curated collection of premium guides, templates, and
                    tools.</p>
            </div>

            {{-- Search & Mobile Toggle --}}
            <div class="w-full md:w-80 group">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search your library..."
                        class="w-full pl-12 pr-4 py-4 bg-white border border-gray-100 rounded-2xl focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all font-bold text-gray-900 shadow-sm placeholder:text-gray-300">
                    <div
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Type Filters --}}
        <div class="mt-8 flex items-center gap-4 overflow-x-auto no-scrollbar pb-2">
            <button wire:click="resetFilters"
                class="px-5 py-2.5 rounded-xl border font-black text-[10px] uppercase tracking-wider transition-all {{ $selectedType === '' ? 'bg-gray-900 border-gray-900 text-white shadow-lg' : 'bg-white border-gray-200 text-gray-500 hover:border-primary-200 hover:text-primary-600' }}">
                All Resources
            </button>
            @foreach($resourceTypes as $type)
                <button wire:click="filterByType('{{ $type->value }}')"
                    class="px-5 py-2.5 rounded-xl border font-black text-[10px] uppercase tracking-wider transition-all whitespace-nowrap {{ $selectedType === $type->value ? 'bg-primary-600 border-primary-600 text-white shadow-lg shadow-primary-600/20' : 'bg-white border-gray-200 text-gray-500 hover:border-primary-200 hover:text-primary-600' }}">
                    {{ $type->label() }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Content --}}
    @if($resources->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-8 mb-12">
            @foreach($resources as $resource)
                <div class="transform transition-all duration-300 hover:scale-[1.01]">
                    <x-resource-card :resource="$resource" :is-saved="true" />
                </div>
            @endforeach
        </div>

        {{-- Custom Pagination --}}
        <div class="mt-16">
            {{ $resources->links() }}
        </div>
    @else
        {{-- High-End Empty State --}}
        <div
            class="bg-white rounded-[3rem] p-20 text-center border border-gray-100 shadow-200/50 max-w-4xl mx-auto relative overflow-hidden group">
            {{-- Decorative pattern --}}
            <div
                class="absolute -top-24 -right-24 w-64 h-64 bg-primary-50 rounded-full blur-3xl opacity-50 group-hover:scale-125 transition-transform duration-700">
            </div>

            <div class="relative flex flex-col items-center">
                <div
                    class="w-24 h-24 bg-gradient-to-br from-primary-50 to-primary-100 rounded-[2.5rem] flex items-center justify-center mb-8 transform group-hover:rotate-12 transition-transform duration-500 shadow-xl shadow-primary-600/5">
                    <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </div>

                <h3 class="text-3xl font-black text-gray-900 mb-4 font-display">
                    @if($search || $selectedType)
                        No matching resources found
                    @else
                        Your library is empty
                    @endif
                </h3>

                <p class="text-gray-500 mb-10 text-lg font-medium max-w-md mx-auto leading-relaxed">
                    @if($search || $selectedType)
                        We couldn't find any saved resources matching your current filters. Try adjusting your search or
                        clearing filters.
                    @else
                        Start building your secret vault of scholarship success. Explore our curated library of professional
                        guides and templates.
                    @endif
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    @if($search || $selectedType)
                        <button wire:click="resetFilters"
                            class="inline-flex items-center px-10 py-5 bg-gray-900 text-white rounded-full font-black text-sm uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-gray-900/10 active:scale-95">
                            Clear Filters
                        </button>
                    @endif

                    <a href="{{ route('resources.index') }}"
                        class="inline-flex items-center px-10 py-5 bg-primary-600 text-white rounded-full font-black text-sm uppercase tracking-widest hover:bg-primary-700 transition-all shadow-xl shadow-primary-600/10 active:scale-95">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Explore Library
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>