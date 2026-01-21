<div class="p-4 bg-red-500 border rounded-lg">
    @if ($url)
        <div class="video-embed-preview">
            <iframe src="{{ $url }}" style="width: 100%; height: {{ $height }}px;" frameborder="0" allowfullscreen>
            </iframe>
        </div>
    @else
        <div class="text-gray-500 text-center py-8">
            Please configure the video URL.
        </div>
    @endif
</div>