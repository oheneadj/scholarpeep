@props([
    'resource',
    'isSaved' => false,
])

@php
    $typeIcons = [
        'guide' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        'template' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'tool' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
        'video' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
        'article' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
        'calculator' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
    ];

    $typeColors = [
        'guide' => 'blue',
        'template' => 'purple',
        'tool' => 'emerald',
        'video' => 'rose',
        'article' => 'amber',
        'calculator' => 'indigo',
    ];

    $color = $typeColors[$resource->resource_type] ?? 'gray';
    $url = $resource->external_url ?: ($resource->file_path ? asset('storage/' . $resource->file_path) : '#');
    $isAuthenticated = auth()->check();
@endphp

<div class="group bg-white rounded-2xl border border-gray-200 hover:shadow-xl transition-all duration-300 overflow-hidden">
    
    {{-- Card Header --}}
    <div class="p-6 pb-4">
        <div class="flex items-start justify-between mb-4">
            {{-- Icon --}}
            <div class="w-14 h-14 bg-gray-900 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons[$resource->resource_type] ?? $typeIcons['article'] }}"/>
                </svg>
            </div>
            
            {{-- Save Button --}}
            <button wire:click="toggleSave({{ $resource->id }})" 
                class="group/save px-4 py-2 rounded-lg border border-gray-200 hover:border-gray-300 bg-white hover:bg-gray-50 transition-all flex items-center gap-2">
                @if($isSaved)
                    <span class="text-sm font-medium text-gray-700">Saved</span>
                    <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                @else
                    <span class="text-sm font-medium text-gray-700">Save</span>
                    <svg class="w-4 h-4 text-gray-400 group-hover/save:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                @endif
            </button>
        </div>

        {{-- Resource Type & Date --}}
        <div class="mb-3">
            <h4 class="text-base font-semibold text-gray-900 mb-1">{{ ucfirst($resource->resource_type) }}</h4>
            <p class="text-sm text-gray-500">{{ $resource->created_at->diffForHumans() }}</p>
        </div>

        {{-- Title --}}
        <h3 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 leading-tight">
            {{ $resource->title }}
        </h3>

        {{-- Tags --}}
        <div class="flex flex-wrap gap-2 mb-4">
            <span class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium border border-gray-200">
                {{ ucfirst($resource->resource_type) }}
            </span>
            @if($resource->resource_type === 'guide')
                <span class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-100">
                    Senior level
                </span>
            @elseif($resource->resource_type === 'template')
                <span class="px-3 py-1.5 bg-purple-50 text-purple-700 rounded-lg text-sm font-medium border border-purple-100">
                    Flexible
                </span>
            @elseif($resource->resource_type === 'tool')
                <span class="px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-medium border border-emerald-100">
                    Free Access
                </span>
            @elseif($resource->resource_type === 'video')
                <span class="px-3 py-1.5 bg-rose-50 text-rose-700 rounded-lg text-sm font-medium border border-rose-100">
                    Remote
                </span>
            @endif
        </div>

        @if($resource->description)
            <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
                {{ $resource->description }}
            </p>
        @endif
    </div>

    {{-- Card Footer --}}
    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
        {{-- Price/Access Info --}}
        <div>
            @auth
                <p class="text-sm text-gray-500 mb-0.5">Free Access</p>
                <p class="text-lg font-bold text-gray-900">Available Now</p>
            @else
                <p class="text-sm text-gray-500 mb-0.5">Sign up required</p>
                <p class="text-lg font-bold text-gray-900">Free</p>
            @endguest
        </div>

        {{-- Action Button --}}
        @auth
            <a href="{{ $url }}" 
               target="{{ $resource->external_url ? '_blank' : '_self' }}"
               class="px-6 py-2.5 bg-gray-900 hover:bg-gray-800 text-white rounded-lg text-sm font-semibold transition-all shadow-sm hover:shadow-md active:scale-95">
                Access now
            </a>
        @else
            <a href="{{ route('register') }}" 
               class="px-6 py-2.5 bg-gray-900 hover:bg-gray-800 text-white rounded-lg text-sm font-semibold transition-all shadow-sm hover:shadow-md active:scale-95">
                Sign Up Free
            </a>
        @endguest
    </div>
</div>
