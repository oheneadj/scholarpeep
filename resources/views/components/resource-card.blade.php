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

    $typeValue = $resource->resource_type instanceof \App\Enums\ResourceType ? $resource->resource_type->value : $resource->resource_type;
    $color = $typeColors[$typeValue] ?? 'gray';
    
    // Use the tracking routes to enable metric recording
    $url = route('resources.show', $resource);
    $isAuthenticated = auth()->check();

    // Check if resource is less than 30 days old
    $isNew = $resource->created_at->gt(now()->subDays(30));
@endphp

<div class="group bg-white rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
    
    {{-- Card Header --}}
    <div class="p-6 flex-1">
        <div class="flex items-start justify-between mb-6">
            {{-- Icon --}}
            <div class="w-14 h-14 bg-gray-900 rounded-2xl flex items-center justify-center shrink-0 shadow-lg shadow-gray-200">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons[$typeValue] ?? $typeIcons['article'] }}"/>
                </svg>
            </div>
            
            {{-- Save Button --}}
            <button wire:click="toggleSave({{ $resource->id }})" 
                class="group/save px-4 py-2 rounded-xl border border-gray-100 hover:border-primary-100 bg-white hover:bg-primary-50/30 transition-all flex items-center gap-2">
                @if($isSaved)
                    <span class="text-[10px] font-bold uppercase tracking-widest text-primary-600">Saved</span>
                    <svg class="w-3.5 h-3.5 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                @else
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 group-hover/save:text-primary-600">Save</span>
                    <svg class="w-3.5 h-3.5 text-gray-300 group-hover/save:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                @endif
            </button>
        </div>

        {{-- Resource Type & Date --}}
        <div class="flex items-center gap-2 mb-3">
            <span class="text-[10px] font-bold text-primary-600 uppercase tracking-widest">
                {{ $resource->resource_type instanceof \App\Enums\ResourceType ? $resource->resource_type->label() : ucfirst($resource->resource_type) }}
            </span>
            <span class="w-1 h-1 rounded-full bg-gray-200"></span>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $resource->created_at->diffForHumans() }}</span>
        </div>

        {{-- Title --}}
        <h3 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 leading-tight tracking-tight group-hover:text-primary-600 transition-colors">
            {{ $resource->title }}
        </h3>

        {{-- Tags --}}
        <div class="flex flex-wrap gap-2 mb-6">
            @if($isNew)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary-600 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest shadow-md shadow-primary-200">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    New
                </span>
            @endif
            <span class="px-3 py-1.5 bg-gray-50 text-gray-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-gray-100">
                {{ $resource->resource_type instanceof \App\Enums\ResourceType ? $resource->resource_type->label() : ucfirst($resource->resource_type) }}
            </span>
        </div>

        @if($resource->description)
            <p class="text-sm text-gray-500 font-medium line-clamp-2 leading-relaxed">
                {{ $resource->description }}
            </p>
        @endif
    </div>

    {{-- Card Footer --}}
    <div class="px-6 py-5 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between mt-auto">
        {{-- Price/Access Info --}}
        <div>
            @auth
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Free Access</p>
                <p class="text-sm font-bold text-gray-900">Available Now</p>
            @else
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Membership Required</p>
                <p class="text-sm font-bold text-gray-900">Sign up Free</p>
            @endguest
        </div>

        {{-- Action Button --}}
        @auth
            <a href="{{ $url }}" 
               target="{{ $resource->external_url ? '_blank' : '_self' }}"
               class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-full text-[10px] font-bold uppercase tracking-widest transition-all shadow-md shadow-primary-200 active:scale-95">
                Access now
            </a>
        @else
            <a href="{{ route('register') }}" 
               class="px-6 py-2.5 bg-gray-900 hover:bg-black text-white rounded-full text-[10px] font-bold uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Unlock
            </a>
        @endguest
    </div>
</div>
