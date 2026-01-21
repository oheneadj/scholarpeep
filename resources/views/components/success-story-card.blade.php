@props(['story'])

<div
    class="flex-none w-[350px] sm:w-[400px] bg-white rounded-2xl p-8 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full group">
    <div class="mb-6 relative">
        <svg class="absolute top-0 left-0 transform -translate-x-2 -translate-y-3 w-8 h-8 text-primary-100 opacity-50"
            fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
            <path
                d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
        </svg>
        <p class="text-gray-600 italic leading-relaxed relative z-10 pl-4">
            "{{ Str::limit($story->story, 150) }}"</p>
    </div>

    <div class="flex items-center gap-4 border-t border-gray-50 pt-6 mt-2">
        <div class="relative w-10 h-10 flex-shrink-0">
            <img src="{{ $story->photo_url }}" alt="{{ $story->student_name }}"
                class="w-full h-full rounded-full object-cover border-2 border-white shadow-sm group-hover:border-primary-100 transition-colors"
                loading="lazy">
            <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-0.5 shadow-sm">
                @php
                    $iso = Str::lower(\App\Models\Country::where('name', '=', $story->country, 'and')->first()?->iso_alpha2 ?? 'us');
                @endphp
                <x-dynamic-component :component="'flag-country-' . $iso" class="w-3 h-3 rounded-full" />
            </div>
        </div>
        <div>
            <h4 class="font-bold text-gray-900 text-sm">{{ $story->student_name }}</h4>
            <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">
                {{ $story->university }}
            </p>
        </div>
    </div>
</div>