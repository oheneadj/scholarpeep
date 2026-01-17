<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Header --}}
    <div class="mb-10">
        <h1 class="text-3xl font-black font-display text-gray-900 mb-2">Saved Resources</h1>
        <p class="text-gray-500 font-medium">Your personal collection of guides, templates, and tools.</p>
    </div>

    {{-- Content --}}
    @if($resources->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6 mb-12">
            @foreach($resources as $resource)
                <x-resource-card :resource="$resource" :is-saved="true" />
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $resources->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-[2.5rem] p-12 text-center border border-gray-100 shadow-xl shadow-gray-200/40">
            <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-6 transform rotate-3">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 mb-2">No saved resources yet</h3>
            <p class="text-gray-500 mb-8 max-w-sm mx-auto">Start exploring our library of guides and tools to build your
                personal collection.</p>
            <a href="{{ route('resources.index') }}"
                class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                Browse Resources
            </a>
        </div>
    @endif
</div>