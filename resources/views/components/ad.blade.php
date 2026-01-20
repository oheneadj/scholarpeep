@props(['position' => \App\Enums\AdPosition::SIDEBAR])

@php
    $positionEnum = $position instanceof \App\Enums\AdPosition
        ? $position
        : \App\Enums\AdPosition::tryFrom($position);

    $ad = $positionEnum ? \App\Models\Ad::active()
        ->position($positionEnum)
        ->inRandomOrder()
        ->first() : null;
@endphp

@if($ad)
    <div class="ad-container group/ad" data-ad-id="{{ $ad->id }}">
        <a href="{{ route('ads.track', $ad) }}" target="_blank" rel="noopener noreferrer"
            class="block overflow-hidden rounded-2xl transition-all duration-500 hover:shadow-2xl hover:shadow-primary-900/10 hover:scale-[1.01] border border-gray-100">
            <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-full h-auto object-cover"
                loading="lazy" />
        </a>
        <p
            class="text-[10px] font-bold text-gray-400 mt-3 text-center uppercase tracking-widest opacity-60 group-hover/ad:opacity-100 transition-opacity">
            Advertisement</p>
    </div>

    @script
    <script>
        {
            // Track impression when ad is viewed
            const adContainer = document.querySelector('[data-ad-id="{{ $ad->id }}"]');
            if (adContainer) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Track impression via AJAX
                            fetch('/ads/{{ $ad->id }}/impression', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });

                observer.observe(adContainer);
            }
        }
    </script>
    @endscript
@endif