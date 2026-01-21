<div class="p-4 bg-gray-50 border border-dashed border-gray-300 rounded-lg flex items-center justify-center gap-4">
    @if($ad)
        <div class="flex items-center gap-4">
            <img src="{{ $ad->image_url }}" alt="{{ $ad->title }}" class="w-16 h-16 object-cover rounded-md bg-gray-200">
            <div>
                <p class="font-bold text-sm text-gray-900">{{ $ad->title }}</p>
                <p class="text-xs text-gray-500">Specified Ad</p>
            </div>
        </div>
    @else
        <div class="flex items-center gap-2 text-gray-500">
            <span class="font-medium text-sm">Random In-Text Ad Placeholder</span>
        </div>
    @endif
</div>