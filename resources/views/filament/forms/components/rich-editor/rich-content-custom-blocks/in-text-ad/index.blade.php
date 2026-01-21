@php
    // If no specific ad was passed, try to fetch a random active in-text ad
    $displayAd = $ad ?? \App\Models\Ad::active()
        ->position(\App\Enums\AdPosition::IN_TEXT)
        ->inRandomOrder()
        ->first();
@endphp

@if($displayAd)
    <div class="flex h-auto w-full justify-center p-2">
        <div class="w-full max-w-2xl" data-ad-id="{{ $displayAd->id }}">
            <a href="{{ route('ads.track', $displayAd) }}" target="_blank" rel="noopener noreferrer"
                class="block w-full overflow-hidden rounded-2xl border border-gray-100 bg-white p-2 transition-all duration-500 hover:scale-[1.01] hover:shadow-2xl hover:shadow-primary-900/10">
                <img src="{{ $displayAd->image_url }}" alt="{{ $displayAd->title }}"
                    class="h-auto w-full rounded-xl object-cover" loading="lazy" />
            </a>
            <p
                class="text-[10px] font-bold text-gray-400 text-center uppercase tracking-widest opacity-60 group-hover/ad:opacity-100 transition-opacity">
                Advertisement</p>
        </div>

        <script>
            (function () {
                var adId = @json($displayAd->id);
                var adContainer = document.querySelector('[data-ad-id="' + adId + '"]');

                if (adContainer) {
                    var observer = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                // Track impression via AJAX
                                fetch('/ads/' + adId + '/impression', {
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
            })();
        </script>
    </div>
@endif