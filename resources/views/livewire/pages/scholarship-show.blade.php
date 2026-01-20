@section('meta')
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org/",
      "@@type": "Scholarship",
      "name": "{{ $scholarship->title }}",
      "description": "{{ Str::limit(strip_tags($scholarship->description), 300) }}",
      "award": {
        "@@type": "MonetaryAmount",
        "currency": "{{ $scholarship->currency }}",
        "value": "{{ $scholarship->award_amount }}"
      },
      "provider": {
        "@@type": "Organization",
        "name": "{{ $scholarship->provider_name }}"
      },
      "validThrough": "{{ $scholarship->primary_deadline?->format('Y-m-d') }}",
      "educationalLevel": "{{ $scholarship->educationLevels->first()?->name }}",
      "url": "{{ route('scholarships.show', $scholarship->slug) }}"
    }
    </script>
@endsection

<div class="bg-[#fcfcfd]" x-data="{ 
    scrolled: false,
    scrolledPercentage: 0,
    updateScroll() {
        this.scrolled = window.pageYOffset > 100;
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        this.scrolledPercentage = (winScroll / height) * 100;
    }
}" @scroll.window="updateScroll()" x-init="updateScroll()">
    <!-- Premium Header / Hero -->
    <header class="relative bg-white pt-24 pb-12 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-soft-blue opacity-30 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-soft-purple opacity-20 rounded-full blur-[120px] translate-y-1/2 -translate-x-1/2"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-[10px] font-extrabold uppercase tracking-[0.2em] text-primary-600/60" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-primary-600 transition">Scholarpeep</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('scholarships.index') }}" class="hover:text-primary-600 transition">Scholarships</a></li>
                    
                    @if($scholarship->scholarshipTypes->first())
                        <li><span class="mx-2">/</span></li>
                        <li>
                            <a href="{{ route('scholarships.index', ['type' => $scholarship->scholarshipTypes->first()->slug]) }}" class="hover:text-primary-600 transition">
                                {{ $scholarship->scholarshipTypes->first()->name }}
                            </a>
                        </li>
                    @endif
                    
                    <li><span class="mx-2">/</span></li>
                    <li class="text-primary-900 truncate max-w-[200px] md:max-w-xs" title="{{ $scholarship->title }}">{{ $scholarship->title }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-end">
                <div class="lg:col-span-8">
                    <div class="flex items-center gap-4 mb-6">
                        @foreach($scholarship->scholarshipTypes as $type)
                             <span class="px-4 py-1.5 bg-primary-600 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl shadow-lg ring-4 ring-primary-600/10">{{ $type->name }}</span>
                        @endforeach
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $scholarship->primary_deadline?->format('M d, Y') ?? 'Rolling Application' }}</span>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-bold font-display text-gray-900 mb-8 leading-[1.1]">
                        {{ $scholarship->title }}
                    </h1>
                    <p class="text-xl text-gray-500 leading-relaxed max-w-3xl font-medium">
                        {{ Str::limit(strip_tags($scholarship->description), 180) }}
                    </p>
                </div>
                <div class="lg:col-span-4 flex justify-end">
                     <div class="flex items-center border-b border-gray-100 gap-4 p-4 bg-white rounded-3xl border border-gray-100">
                        <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-inner border border-gray-50">
                            <img src="{{ $scholarship->provider_logo ?? 'https://ui-avatars.com/api/?name='.urlencode($scholarship->provider_name) }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-[10px] font-extrabold text-primary-600 uppercase tracking-widest mb-1">Provider</p>
                            <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $scholarship->provider_name }}</h3>
                        </div>
                     </div>
                </div>
            </div>

            <!-- Main Featured Image -->
            <div class="mt-16 relative aspect-[21/9] rounded-xl overflow-hidden shadow border-8 border-white group">
                <img src="{{ $scholarship->featured_image ?? 'https://images.unsplash.com/photo-152305085306e-8c44f2322a5e?auto=format&fit=crop&q=80&w=1200' }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[4000ms]" 
                     alt="{{ $scholarship->title }}">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 via-transparent to-transparent"></div>
            </div>
        </div>
    </header>

    @php
        $words = str_word_count(strip_tags($scholarship->description));
        $readingTime = max(1, ceil($words / 200));
    @endphp

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">
            <!-- Left Floating Metabar -->
            <x-metabar 
                :title="$scholarship->title" 
                :readingTime="$readingTime" 
                :isSaved="$isSaved" 
                :showSave="true"
            />

            <!-- Main: Article Content -->
            <main class="lg:col-span-7 space-y-16">
                <!-- Meta Grid -->
                <!-- Quick Stats Meta Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 not-prose">
                    <x-quick-stat-card 
                        theme="emerald" 
                        label="Award Amount" 
                        :value="number_format($scholarship->award_amount) . ' ' . $scholarship->currency">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </x-slot:icon>
                    </x-quick-stat-card>

                    <x-quick-stat-card 
                        theme="blue" 
                        label="Target Country" 
                        :value="$scholarship->countries->first()->name ?? 'Global'"
                        title="{{ $scholarship->countries->first()->name ?? 'Global' }}">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h.293m1.414 0l.086.086a2 2 0 01.586 1.414V14a2 2 0 01-2 2h-1.5a2 2 0 00-2 2v1.5a2 2 0 01-2 2H12m-2-3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </x-slot:icon>
                    </x-quick-stat-card>

                    <x-quick-stat-card 
                        theme="indigo" 
                        label="Study Level" 
                        :value="$scholarship->educationLevels->first()->name ?? 'Any Level'"
                        title="{{ $scholarship->educationLevels->first()->name ?? 'Any Level' }}">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                        </x-slot:icon>
                    </x-quick-stat-card>

                    <x-quick-stat-card 
                        theme="amber" 
                        label="Focus Field" 
                        :value="$scholarship->fieldsOfStudy->first()->name ?? 'General'"
                        title="{{ $scholarship->fieldsOfStudy->first()->name ?? 'General' }}">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </x-slot:icon>
                    </x-quick-stat-card>
                </div>

                <!-- Rich Text -->
                <article class="prose prose-xl prose-primary prose-headings:font-display prose-headings:font-bold prose-p:text-gray-500 prose-p:leading-relaxed max-w-none">
                    <h2 class="text-3xl text-gray-900 mb-8">Detailed Scholarship Overview</h2>
                    <div class="whitespace-pre-line text-gray-600">
                        {!! $scholarship->description  !!}
                    </div>

                    <h2 class="text-3xl text-gray-900 mt-16 mb-8">Eligibility & Criteria</h2>
                    <div class="bg-gray-50 rounded-[2rem] p-10 border border-gray-100 not-prose">
                        <div class="space-y-6">
                            @php 
                                $criteria = explode("\n", $scholarship->eligibility_criteria);
                            @endphp
                            @foreach($criteria as $item)
                                @if(trim($item))
                                    <div class="flex items-start gap-4">
                                        <div class="w-6 h-6 rounded-full bg-primary-600/10 flex items-center justify-center text-primary-600 shrink-0 mt-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <span class="text-gray-700 font-medium leading-relaxed">{{ ltrim($item, '- ') }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    @if($scholarship->deadlines->count() > 0)
                        <div class="mt-24 mb-12">
                            <h2 class="text-3xl font-bold font-display text-gray-900 mb-2">Application Timeline</h2>
                            <p class="text-gray-500 font-medium">Clear dates to help you plan your submission effectively.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 not-prose">
                            @foreach($scholarship->deadlines->sortBy('date') as $deadline)
                                @php
                                    $isPriority = str_contains(strtolower($deadline->type->label()), 'priority');
                                    $isExpired = $deadline->date && $deadline->date->isPast();
                                    $isSoon = $deadline->date && $deadline->date->isFuture() && $deadline->date->diffInDays(now()) <= 14;
                                @endphp
                                <div class="relative p-10 bg-white border {{ $isPriority ? 'border-primary-100 bg-primary-50/10' : 'border-gray-100' }} rounded-[2.5rem] shadow-sm overflow-hidden group hover:border-primary-500 hover:shadow-2xl hover:shadow-primary-900/5 transition-all duration-500">
                                    <!-- Decorative Polish -->
                                    <div class="absolute -top-12 -right-12 w-32 h-32 {{ $isPriority ? 'bg-primary-500/5' : 'bg-gray-500/5' }} rounded-full blur-3xl transition-transform group-hover:scale-150"></div>
                                    
                                    <div class="flex flex-col gap-6 relative z-10">
                                        <div class="flex items-center justify-between">
                                            <div class="w-16 h-16 rounded-2xl {{ $isPriority ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/30' : 'bg-gray-50 text-gray-400 group-hover:bg-primary-50 group-hover:text-primary-600' }} flex items-center justify-center transition-all duration-500">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"/>
                                                </svg>
                                            </div>
                                            
                                            <div class="flex flex-col items-end gap-2">
                                                @if($isExpired)
                                                    <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-extrabold uppercase tracking-widest rounded-full border border-red-100">Closed</span>
                                                @elseif($isSoon)
                                                    <span class="px-3 py-1 bg-orange-50 text-orange-600 text-[10px] font-extrabold uppercase tracking-widest rounded-full border border-orange-100 animate-pulse">Closing Soon</span>
                                                @elseif($isPriority)
                                                    <span class="px-3 py-1 bg-primary-600 text-white text-[10px] font-extrabold uppercase tracking-widest rounded-full shadow-md">Priority</span>
                                                @endif

                                                @if(!$isExpired && $deadline->date)
                                                    <button 
                                                        wire:click="addToCalendar('{{ $deadline->date->format('Y-m-d') }}')"
                                                        wire:loading.attr="disabled"
                                                        class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-100 rounded-xl text-[10px] font-bold text-gray-500 hover:text-primary-600 hover:border-primary-100 hover:bg-primary-50 transition-all shadow-sm"
                                                        title="Add to Google Calendar"
                                                    >
                                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7v-5z"/>
                                                        </svg>
                                                        Sync
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">{{ $deadline->type->label() }}</p>
                                            <div class="flex items-baseline gap-2">
                                                <h3 class="text-2xl font-bold text-gray-900 font-display transition-colors group-hover:text-primary-700">
                                                    {{ $deadline->date?->format('F j, Y') ?? 'TBD' }}
                                                </h3>
                                            </div>
                                            @if($deadline->date && $deadline->date->isFuture())
                                                <p class="mt-2 text-sm font-medium text-gray-500 flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                                    {{ $deadline->date->diffForHumans() }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Hover Arrow Overlay -->
                                    <div class="absolute bottom-6 right-8 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-500">
                                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </article>

                <!-- Action CTA -->
                <!-- Featured Tips & Articles Slider -->
                @if($featuredPosts->count() > 0)
                <div class="space-y-6">
                    <h3 class="text-xl font-bold font-display text-gray-950 px-2 flex items-center gap-3">
                        <span class="w-2 h-8 bg-primary-600 rounded-full"></span>
                        Expert Insights
                    </h3>
                    <x-widgets.featured-posts-slider :posts="$featuredPosts" />
                </div>
                @endif

                <!-- Reviews Section -->
                <section class="mt-24 space-y-12">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-bold font-display text-gray-900 mb-2">Community Reviews</h2>
                            <p class="text-gray-500 font-medium">Real feedback from students like you.</p>
                        </div>
                        <div class="flex flex-col items-end">
                            <div class="flex items-center gap-1 text-amber-400">
                                @php $avgRating = $scholarship->reviews->avg('rating') ?: 0; @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $avgRating ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <span class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest">{{ $scholarship->reviews->count() }} Reviews</span>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-8">
                        @forelse($scholarship->reviews as $review)
                            <div class="p-8 bg-white border border-gray-100 rounded-[2.5rem] shadow-sm">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-600 font-bold overflow-hidden">
                                            @if($review->is_anonymous)
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=eff6ff&color=3b82f6" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $review->is_anonymous ? 'Anonymous Student' : $review->user->name }}</h4>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $review->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-0.5 text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-100 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 leading-relaxed">{{ $review->comment }}</p>
                                @if($review->is_verified)
                                    <div class="mt-4 flex items-center gap-1.5 text-emerald-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.64.304 1.24.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        <span class="text-[10px] font-bold uppercase tracking-widest">Verified Reviewer</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-12 bg-gray-50 rounded-[2.5rem] border border-dashed border-gray-200">
                                <p class="text-gray-500 font-medium">No reviews yet. Be the first to share your experience!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Review Form -->
                    @auth
                        <div class="mt-16 p-10 bg-gray-900 rounded-[2.5rem] text-white">
                            <h3 class="text-2xl font-bold font-display mb-2">Share your experience</h3>
                            <p class="text-gray-400 mb-8 font-medium">How was the application process for this scholarship?</p>

                            <form wire:submit="submitReview" class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">Your Rating</label>
                                    <div class="flex items-center gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none transition-transform hover:scale-110">
                                                <svg class="w-8 h-8 {{ $i <= $rating ? 'text-amber-400 fill-current' : 'text-gray-700 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            </button>
                                        @endfor
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Your Comment</label>
                                    <textarea wire:model="comment" rows="4" class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all placeholder:text-gray-600" placeholder="Tell us about the process, requirements, or any tips for other students..."></textarea>
                                    @error('comment') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex items-center justify-between">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <div class="relative">
                                            <input type="checkbox" wire:model="isAnonymous" class="sr-only">
                                            <div class="w-10 h-6 bg-gray-700 rounded-full transition-colors group-hover:bg-gray-600 shadow-inner"></div>
                                            <div class="absolute inset-y-1 left-1 w-4 h-4 bg-white rounded-full transition-transform transform" :class="$wire.isAnonymous ? 'translate-x-4' : ''"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Post Anonymously</span>
                                    </label>

                                    <button type="submit" class="px-8 py-3 bg-primary-600 text-white font-bold uppercase tracking-wider rounded-xl hover:bg-primary-500 transition-all shadow-lg shadow-primary-900/20 active:scale-95">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mt-16 p-10 bg-gray-50 rounded-[2.5rem] border border-gray-100 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Want to share your experience?</h3>
                            <p class="text-gray-500 mb-8 font-medium">Sign in to your account to leave a review and help other students.</p>
                            <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3 bg-gray-900 text-white font-bold uppercase tracking-wider rounded-xl hover:bg-gray-800 transition-all shadow-lg">
                                Sign In to Review
                            </a>
                        </div>
                    @endauth
                </section>

                <!-- Primary CTA -->
                <div class="p-10 bg-primary-950 rounded-xl overflow-hidden relative shadow-2xl group/cta">
                    <div class="absolute inset-0 bg-blob-blue opacity-20 group-hover:opacity-30 transition-opacity"></div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold font-display text-white mb-4 leading-tight">Ready to kickstart your application?</h3>
                        <p class="text-primary-100 mb-8 leading-relaxed">We'll redirect you to the official provider portal to start your journey.</p>
                        <button wire:click="apply" class="w-full py-5 bg-white text-primary-900 rounded-2xl font-black shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 group/btn">
                            Apply Now
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Advertisement Section -->
                <div class="bg-gray-50/50 rounded-2xl p-6 border border-gray-100/50">
                    <x-ad position="{{ \App\Enums\AdPosition::IN_TEXT }}" />
                </div>
            </main>

            <!-- Right: Sticky Sidebar -->
            <aside class="lg:col-span-4 space-y-12">
                <!-- Author Bio -->
                <x-widgets.author-widget 
                    name="Scholarpeep" 
                    role="Curation Team"
                    bio="Our team of experts manually verifies and selects only the highest-quality scholarship opportunities globally."
                    avatar="https://ui-avatars.com/api/?name=Scholarpeep+Team&background=1e3a8a&color=fff"
                    location="San Francisco, CA"
                    :socials="[
                        'x' => '#',
                        'facebook' => '#',
                        'instagram' => '#',
                        'linkedin' => '#'
                    ]"
                />

                <!-- Categories -->
                <x-widgets.topics-list :topics="$topics" title="Scholarship Types" />

                <!-- Featured Scholarships -->
                <x-widgets.featured-scholarships-widget :scholarships="$featuredScholarships" />

                <!-- Newsletter Widget -->
                <x-widgets.newsletter-widget />

                <!-- Sticky Ad Widget -->
                <x-widgets.ad-widget />
            </aside>
        </div>
    </div>

    <!-- Related Scholarships Section -->
    <section class="bg-gray-50 py-24 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold font-display text-gray-900 mb-2">Related Scholarships</h2>
                    <p class="text-gray-500">Similar opportunities you might be interested in</p>
                </div>
                <a href="{{ route('scholarships.index') }}" class="text-primary-600 font-bold hover:text-primary-700 flex items-center gap-2 group transition-all">
                    View all scholarships
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>

            @if($similarScholarships->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($similarScholarships->take(3) as $similar)
                        <x-scholarship-card :scholarship="$similar" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">No related scholarships found</h3>
                    <p class="text-gray-500 mb-6">Check out all available scholarships instead</p>
                    <a href="{{ route('scholarships.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white rounded-full font-bold hover:bg-primary-700 transition-all">
                        Browse all scholarships
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
            @endif
        </div>
    </section>
</div>
