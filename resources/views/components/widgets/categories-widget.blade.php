@props(['categories'])

<div class="bg-white rounded-xl p-8 border border-gray-100 shadow">
    <h3 class="font-bold text-gray-900 text-lg mb-4">Categories</h3>
    <div class="flex flex-wrap gap-2">
        @php
            $colors = [
                'bg-blue-600 text-white hover:bg-blue-500',
                'bg-purple-600 text-white hover:bg-purple-500',
                'bg-green-600 text-white hover:bg-green-500',
                'bg-pink-600 text-white hover:bg-pink-500',
                'bg-orange-600 text-white hover:bg-orange-500',
                'bg-teal-600 text-white hover:bg-teal-500',
                'bg-indigo-600 text-white hover:bg-indigo-100',
            ];
        @endphp
        @foreach($categories as $index => $cat)
            <a href="#"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $colors[$index % count($colors)] }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>
</div>