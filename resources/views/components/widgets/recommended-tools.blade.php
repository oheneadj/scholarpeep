@props(['tools' => []])

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-200/50 group/tools relative">
    {{-- Background Decorative Glow --}}
    <div
        class="absolute -bottom-12 -left-12 w-32 h-32 bg-purple-50 rounded-full blur-[40px] opacity-60 group-hover/tools:opacity-80 transition-opacity duration-700">
    </div>

    <div class="p-5 relative z-10">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div
                    class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 border border-purple-100 group-hover/tools:scale-110 transition-transform duration-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 leading-none mb-1">Recommended Tools</h4>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">Curated
                        Resources</p>
                </div>
            </div>
        </div>

        @if(count($tools) > 0)
            <div class="grid grid-cols-1 gap-3">
                @foreach($tools as $tool)
                    <a href="{{ route('affiliate.go', $tool->slug) }}" target="_blank"
                        class="flex items-center gap-3 p-3 bg-gray-50/50 hover:bg-white rounded-xl border border-transparent hover:border-purple-100 hover:shadow-md transition-all duration-300 group/item">
                        <div
                            class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-purple-600 shadow-sm border border-gray-100 group-hover/item:scale-110 transition-transform">
                            @if($tool->icon)
                                {{-- Assuming icon is a name for a component or svg path --}}
                                <x-dynamic-component :component="$tool->icon" class="w-5 h-5" />
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5
                                class="text-xs font-bold text-gray-900 mb-0.5 truncate group-hover/item:text-purple-600 transition-colors">
                                {{ $tool->name }}
                            </h5>
                            <p class="text-[10px] text-gray-500 line-clamp-1 leading-tight">{{ $tool->description }}</p>
                        </div>
                        <div
                            class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 group-hover/item:bg-purple-600 group-hover/item:text-white transition-all">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 bg-gray-50/50 rounded-xl border border-dashed border-gray-200">
                <p class="text-xs font-semibold text-gray-500">Coming Soon</p>
                <p class="text-[10px] text-gray-400 mt-1">We're curating the best tools for you.</p>
            </div>
        @endif
    </div>
</div>