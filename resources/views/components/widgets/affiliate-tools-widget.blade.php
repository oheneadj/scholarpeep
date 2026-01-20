@php
    $tools = \App\Models\AffiliateTool::where('is_active', '=', true)
        ->orderBy('sort_order')
        ->take(5)
        ->get();
@endphp

@if($tools->isNotEmpty())
    <div class="bg-white rounded-xl p-8 border border-gray-100 shadow-sm">
        <h3 class="font-bold text-gray-400 text-xs uppercase tracking-wider mb-6">Creating</h3>

        <div class="space-y-8">
            @foreach($tools as $tool)
                <!-- Tool Item -->
                <div class="group relative">
                    <h4 class="text-lg font-bold text-primary-600 mb-2 flex items-center gap-2">
                        {{ $tool->name }}
                        <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </h4>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        {{ $tool->description }}
                    </p>
                    <a href="{{ route('affiliate.go', $tool->slug) }}" target="_blank" class="absolute inset-0 z-10"
                        aria-label="View Tool"></a>
                </div>
            @endforeach
        </div>
    </div>
@endif