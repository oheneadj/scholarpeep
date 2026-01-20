@props(['scholarship', 'view' => 'grid'])

@php
    $isPremium = $scholarship->sponsorship_tier === \App\Enums\SponsorshipTier::PREMIUM;
    $isFeatured = $scholarship->sponsorship_tier === \App\Enums\SponsorshipTier::FEATURED;
    $isStandard = $scholarship->sponsorship_tier === \App\Enums\SponsorshipTier::STANDARD;
@endphp

@if($view === 'grid')
    <div {{ $attributes->merge(['class' => 'group bg-white rounded-xl border shadow hover:shadow-xl hover:shadow-primary-600/5 hover:-translate-y-1 transition-all duration-500 p-8 flex flex-col h-full relative overflow-hidden cursor-pointer ' . ($isPremium ? 'border-purple-600' : ($isFeatured ? 'border-orange-500' : 'border-gray-100'))]) }} x-data="{ 
                        copied: false,
                        copyLink() {
                            const text = '{{ route('scholarships.show', $scholarship->slug) }}';
                            if (navigator.clipboard && window.isSecureContext) {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.copied = true;
                                    setTimeout(() => this.copied = false, 2000);
                                });
                            } else {
                                const textArea = document.createElement('textarea');
                                textArea.value = text;
                                document.body.appendChild(textArea);
                                textArea.select();
                                try {
                                    document.execCommand('copy');
                                    this.copied = true;
                                    setTimeout(() => this.copied = false, 2000);
                                } catch (err) {
                                    console.error('Fallback: Unable to copy', err);
                                }
                                document.body.removeChild(textArea);
                            }
                        }
                    }" onclick="window.location.href='{{ route('scholarships.show', $scholarship->slug) }}'">
        @if(!$isStandard)
            <div @class([
                'absolute top-0 right-0 py-1.5 px-6 text-white text-[10px] uppercase font-black tracking-[0.2em] rounded-bl-3xl shadow-lg z-10 flex items-center gap-2',
                'bg-gradient-to-r from-purple-600 to-indigo-600' => $isPremium,
                'bg-gradient-to-r from-gold-500 to-orange-500' => $isFeatured,
            ])>
                @if($isPremium)
                    <svg class="w-3 h-3 text-purple-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                @else
                    <svg class="w-3 h-3 text-gold-200" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                @endif
                {{ $scholarship->sponsorship_tier->label() }}
            </div>

            @if($isPremium)
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-500/5 via-transparent to-indigo-500/5 pointer-events-none">
                </div>
                <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-purple-500/10 rounded-full blur-3xl pointer-events-none">
                </div>
            @endif
        @endif



        <div class="flex items-center gap-5 mb-8">
            <div
                class="w-16 h-16 bg-gray-50 rounded-xl flex items-center justify-center p-3 border border-gray-100 group-hover:border-primary-100 transition-colors shrink-0">
                @if($scholarship->provider_logo)
                    <img src="{{ Str::contains($scholarship->provider_logo, 'http') ? $scholarship->provider_logo : \Illuminate\Support\Facades\Storage::url($scholarship->provider_logo) }}"
                        alt="{{ $scholarship->provider_name }}" class="max-h-full max-w-full object-contain">
                @else
                    <img src="{{ asset('img/placeholder-logo.png') }}" alt="{{ $scholarship->provider_name }}"
                        class="max-h-full max-w-full object-contain opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all">
                @endif

            </div>
            <div class="flex-1 min-w-0">
                <h3
                    class="font-bold text-gray-950 group-hover:text-primary-700 transition-colors line-clamp-2 text-xl leading-tight mb-1">
                    {{ $scholarship->title }}
                </h3>
                <p class="text-xs text-gray-400 font-bold truncate tracking-wide uppercase">
                    {{ $scholarship->provider_name }}
                </p>
            </div>
        </div>

        <div class="space-y-4 mb-10 flex-grow">
            <div class="flex flex-wrap gap-2">
                @if($scholarship->countries->first())
                    <span
                        class="px-3 py-1.5 bg-gray-50 text-gray-600 rounded-full text-[10px] font-bold border border-gray-100 flex items-center gap-1.5">
                        <x-dynamic-component :component="'flag-country-' . $scholarship->countries->first()->iso_alpha2"
                            class="w-3 h-3 rounded-full" />
                        {{ $scholarship->countries->first()->name }}</span>
                @endif
                <span
                    class="px-3 py-1.5 bg-gray-50 text-gray-600 rounded-full text-[10px] font-bold border border-gray-100">📅
                    {{ $scholarship->primary_deadline?->format('F j') ?? 'Rolling' }}</span>
            </div>
            <p class="text-sm text-gray-500 line-clamp-2 font-medium leading-relaxed">{{ $scholarship->description }}</p>
            <div class="flex flex-wrap gap-2 pt-2">
                @foreach($scholarship->educationLevels->take(2) as $level)
                    <span
                        class="px-3 py-1 bg-primary-500 text-white rounded-full text-[10px] font-extrabold uppercase tracking-widest">{{ $level->name }}</span>
                @endforeach
            </div>
        </div>

        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
            <div>
                <span class="text-[10px] text-gray-400 uppercase font-extrabold tracking-widest block mb-1">Award</span>
                <span
                    class="text-2xl font-bold text-gray-950 font-display tracking-tight">{{ number_format($scholarship->award_amount) }}
                    <span
                        class="text-primary-600/50 text-sm font-extrabold">{{ $scholarship->currency ?? 'USD' }}</span></span>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <button wire:click.stop="toggleSave({{ $scholarship->id }})"
                        class="p-2 rounded-full bg-gray-50 hover:bg-white border border-transparent hover:border-gray-200 shadow-sm hover:shadow-md transition-all group/save focus:outline-none">
                        @if(in_array($scholarship->id, $this->savedScholarshipIds ?? []))
                            <svg class="w-6 h-6 text-primary-600 fill-current" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-gray-400 group-hover/save:text-primary-600 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        @endif
                    </button>
                @else
                    <button title="Create an account to save your scholarship"
                        class="p-2 rounded-full bg-gray-50 hover:bg-white border border-transparent hover:border-gray-200 shadow-sm hover:shadow-md transition-all cursor-not-allowed group/save">
                        <svg class="w-6 h-6 text-gray-400 group-hover/save:text-primary-600 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </button>
                @endauth
                <button @click.stop="copyLink"
                    class="p-2 rounded-full bg-gray-50 hover:bg-white border border-transparent hover:border-gray-200 shadow-sm hover:shadow-md transition-all group/copy focus:outline-none"
                    title="Copy Link">
                    <svg x-show="!copied" class="w-6 h-6 text-gray-400 group-hover/copy:text-primary-600 transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <svg x-show="copied" x-cloak class="w-6 h-6 text-success-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <a href="{{ route('scholarships.show', $scholarship->slug) }}"
                    class="inline-flex items-center justify-center w-12 h-12 bg-gray-950 text-white rounded-full hover:bg-primary-600 transition-all shadow-lg active:scale-95 group/btn">
                    <svg class="w-6 h-6 group-hover/btn:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
@else
    <div {{ $attributes->merge(['class' => 'group bg-white rounded-2xl border shadow-sm hover:shadow-lg transition-all duration-300 p-6 flex flex-col md:flex-row gap-8 items-center relative overflow-hidden ' . ($isPremium ? 'border-purple-600' : ($isFeatured ? 'border-orange-500' : 'border-gray-100'))]) }} x-data="{ 
                        copied: false,
                        copyLink() {
                            const text = '{{ route('scholarships.show', $scholarship->slug) }}';
                            if (navigator.clipboard && window.isSecureContext) {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.copied = true;
                                    setTimeout(() => this.copied = false, 2000);
                                });
                            } else {
                                const textArea = document.createElement('textarea');
                                textArea.value = text;
                                document.body.appendChild(textArea);
                                textArea.select();
                                try {
                                    document.execCommand('copy');
                                    this.copied = true;
                                    setTimeout(() => this.copied = false, 2000);
                                } catch (err) {
                                    console.error('Fallback: Unable to copy', err);
                                }
                                document.body.removeChild(textArea);
                            }
                        }
                    }" onclick="window.location.href='{{ route('scholarships.show', $scholarship->slug) }}'">
        <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center p-3 border border-gray-100 shrink-0">
            @if($scholarship->provider_logo)
                <img src="{{ Str::contains($scholarship->provider_logo, 'http') ? $scholarship->provider_logo : \Illuminate\Support\Facades\Storage::url($scholarship->provider_logo) }}"
                    alt="{{ $scholarship->provider_name }}" class="max-h-full max-w-full object-contain">
            @else
                <img src="{{ asset('img/placeholder-logo.png') }}" alt="{{ $scholarship->provider_name }}"
                    class="max-h-full max-w-full object-contain opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all">
            @endif

        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 mb-2">
                <h3 class="font-bold text-gray-950 text-xl leading-tight truncate">{{ $scholarship->title }}</h3>
                @if(!$isStandard)
                    <span @class([
                        'px-2.5 py-1 text-[9px] uppercase font-black rounded-full shadow-sm flex items-center gap-1.5',
                        'bg-purple-100 text-purple-700 border border-purple-200' => $isPremium,
                        'bg-gold-100 text-gold-700 border border-gold-200' => $isFeatured,
                    ])>
                        @if($isPremium)
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        @else
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        @endif
                        {{ $scholarship->sponsorship_tier->label() }}
                    </span>
                @endif
            </div>



            <p class="text-xs text-gray-400 font-bold uppercase tracking-wide mb-4">{{ $scholarship->provider_name }}</p>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-500">
                    @if($scholarship->countries->first())
                        <x-dynamic-component :component="'flag-country-' . $scholarship->countries->first()->iso_alpha2"
                            class="w-4 h-4 rounded-full" />
                    @else
                        <span class="text-primary-500">🌍</span>
                    @endif
                    {{ $scholarship->countries->first()->name ?? 'Global' }}
                </div>
                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-500"><span
                        class="text-warning-500">📅</span>
                    {{ $scholarship->primary_deadline?->format('M j, Y') ?? 'Rolling' }}</div>
                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-500"><span
                        class="text-indigo-500">🎓</span> {{ $scholarship->educationLevels->first()->name ?? 'Any' }}</div>
            </div>
        </div>
        <div
            class="flex flex-col items-end shrink-0 pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-gray-50 pl-0 md:pl-8 relative">

            <div class="flex items-center gap-3 mt-auto">
                @auth
                    <button wire:click.stop="toggleSave({{ $scholarship->id }})"
                        class="p-2 rounded-full bg-white hover:bg-gray-50 border border-gray-100 shadow-sm hover:shadow-md transition-all group/save focus:outline-none">
                        @if(in_array($scholarship->id, $this->savedScholarshipIds ?? []))
                            <svg class="w-5 h-5 text-primary-600 fill-current" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-400 group-hover/save:text-primary-600 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        @endif
                    </button>
                @else
                    <button title="Create an account to save your scholarship"
                        class="p-2 rounded-full bg-white hover:bg-gray-50 border border-gray-100 shadow-sm hover:shadow-md transition-all cursor-not-allowed group/save">
                        <svg class="w-5 h-5 text-gray-400 group-hover/save:text-primary-600 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </button>
                @endauth
                <button @click.stop="copyLink"
                    class="p-2 rounded-full bg-white hover:bg-gray-50 border border-gray-100 shadow-sm hover:shadow-md transition-all group/copy focus:outline-none"
                    title="Copy Link">
                    <svg x-show="!copied" class="w-5 h-5 text-gray-400 group-hover/copy:text-primary-600 transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <svg x-show="copied" x-cloak class="w-5 h-5 text-success-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <a href="{{ route('scholarships.show', $scholarship->slug) }}"
                    class="px-6 py-2.5 bg-gray-950 text-white rounded-full text-xs font-bold hover:bg-primary-600 transition-all active:scale-95 shadow-lg">View
                    Details</a>
            </div>

            <div class="mt-4 md:mt-auto mb-4 md:mb-6 text-right w-full">
                <span class="text-[10px] text-gray-400 uppercase font-extrabold tracking-widest block mb-1">Award</span>
                <span class="text-2xl font-bold text-gray-950 font-display">{{ number_format($scholarship->award_amount) }}
                    <span
                        class="text-primary-600/50 text-sm font-extrabold">{{ $scholarship->currency ?? 'USD' }}</span></span>
            </div>
        </div>
    </div>
@endif