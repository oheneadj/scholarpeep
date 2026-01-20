<div class="min-h-screen bg-gray-50 pb-12">
    {{-- Header Section --}}
    <div class="bg-gradient-to-br from-primary-900 via-primary-800 to-purple-900 text-white relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 relative z-10">
            <div class="max-w-4xl">
                {{-- Breadcrumb --}}
                <div class="flex items-center gap-2 text-sm text-primary-200 mb-6 font-medium">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    <svg class="w-3 h-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('resources.index') }}" class="hover:text-white transition-colors">Resources</a>
                    <svg class="w-3 h-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-white truncate">{{ $resource->title }}</span>
                </div>

                <div class="flex flex-col md:flex-row gap-6 md:items-start">
                    {{-- Icon --}}
                    <div class="shrink-0 bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl shadow-xl">
                        @php
                            $typeIcons = [
                                'guide' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                                'template' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                'tool' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
                                'video' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
                                'article' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
                                'calculator' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                            ];
                            $typeValue = $resource->resource_type instanceof \App\Enums\ResourceType ? $resource->resource_type->value : $resource->resource_type;
                        @endphp
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $typeIcons[$typeValue] ?? $typeIcons['article'] }}" />
                        </svg>
                    </div>

                    {{-- Text Content --}}
                    <div>
                        <div class="flex flex-wrap items-center gap-3 mb-4">
                            <span
                                class="px-3 py-1 bg-primary-700/50 backdrop-blur-sm border border-primary-500/30 rounded-full text-xs font-bold uppercase tracking-wider text-white">
                                {{ $resource->resource_type instanceof \App\Enums\ResourceType ? $resource->resource_type->label() : ucfirst($resource->resource_type) }}
                            </span>
                            <span
                                class="px-3 py-1 bg-white/20 backdrop-blur-sm border border-white/20 rounded-full text-xs font-bold uppercase tracking-wider text-white">
                                {{ $resource->category instanceof \App\Enums\ResourceCategory ? $resource->category->label() : ucfirst($resource->category) }}
                            </span>
                            <span class="text-primary-200 text-sm font-medium">
                                {{ $resource->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        <h1 class="text-3xl md:text-5xl font-black font-display mb-6 leading-tight">
                            {{ $resource->title }}
                        </h1>
                        <p class="text-lg text-primary-100 max-w-3xl leading-relaxed">
                            {{ $resource->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Content --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                    <div class="p-8 md:p-12">
                        @if($resource->featured_image)
                            <img src="{{ asset('storage/' . $resource->featured_image) }}" alt="{{ $resource->title }}"
                                class="w-full h-auto rounded-xl mb-8 shadow-md">
                        @endif

                        <div class="prose prose-lg prose-primary max-w-none">
                            {!! $resource->content !!}
                        </div>
                    </div>

                    {{-- Guest Lock Overlay (if content is empty or short, or just to reinforce CTA) --}}
                    @guest
                        <div class="bg-gray-50 border-t border-gray-100 p-8 md:p-12 text-center">
                            <div
                                class="inline-flex w-16 h-16 bg-primary-100 text-primary-600 rounded-full items-center justify-center mb-6">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Unlock Full Access</h3>
                            <p class="text-gray-600 max-w-lg mx-auto mb-8">
                                Sign up for a free ScholarPeep account to download this resource and access our entire
                                library of tools, templates, and guides.
                            </p>
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                                <a href="{{ route('register') }}"
                                    class="w-full sm:w-auto px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-primary-600/30">
                                    Create Free Account
                                </a>
                                <a href="{{ route('login') }}"
                                    class="w-full sm:w-auto px-8 py-3 bg-white hover:bg-gray-50 text-gray-900 font-bold rounded-xl border border-gray-200 transition-all">
                                    Log In
                                </a>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>

            {{-- Right Column: Actions --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Download/Access Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
                    <h3 class="font-bold text-gray-900 mb-6 text-lg">Get this Resource</h3>

                    @auth
                        @if($resource->external_url)
                            <a href="{{ route('resources.view', $resource) }}" target="_blank"
                                class="flex items-center justify-center w-full px-6 py-4 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-bold transition-all shadow-lg mb-3 gap-2">
                                <span>Visit Website</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @elseif($resource->file_path)
                            <a href="{{ route('resources.download', $resource) }}"
                                class="flex items-center justify-center w-full px-6 py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-primary-600/30 mb-3 gap-2">
                                <span>Download File</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        @else
                            <div class="text-center p-4 bg-gray-50 rounded-xl text-gray-500 text-sm">
                                This resource is content-only.
                            </div>
                        @endif
                    @else
                        <div class="p-4 bg-primary-50 rounded-xl border border-primary-100 text-center mb-4">
                            <p class="text-sm text-primary-800 font-medium mb-3">
                                <span class="block text-2xl mb-1">🔒</span>
                                Access restricted to members
                            </p>
                            <a href="{{ route('register') }}"
                                class="block w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-bold transition-colors">
                                Sign Up Free
                            </a>
                        </div>
                        <button disabled
                            class="flex items-center justify-center w-full px-6 py-4 bg-gray-100 text-gray-400 rounded-xl font-bold cursor-not-allowed gap-2">
                            <span>Download File</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </button>
                    @endauth

                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <dl class="space-y-4 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Difficulty</dt>
                                <dd class="font-bold text-gray-900">
                                    {{ $resource->difficulty_level instanceof \App\Enums\DifficultyLevel ? $resource->difficulty_level->label() : ucfirst($resource->difficulty_level) }}
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Downloads</dt>
                                <dd class="font-bold text-gray-900">{{ number_format($resource->downloads_count) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Views</dt>
                                <dd class="font-bold text-gray-900">{{ number_format($resource->views_count) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>