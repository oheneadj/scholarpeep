@props(['topics', 'title' => 'Explore Topics', 'bg' => 'bg-blue-100'])

<div class="{{ $bg }} rounded-[2rem] p-8 border border-gray-100/50 shadow-200/50">
    <h3 class="font-bold text-gray-900 font-display mb-6">{{ $title }}</h3>
    <div class="flex flex-wrap gap-2">
        @foreach($topics as $topic)
            <a href="{{ is_object($topic) ? '#' : '#' }}"
                class="px-4 py-2 bg-blue-600 rounded-full text-xs font-bold text-white shadow-sm border border-blue-200 hover:bg-blue-700 hover:text-white hover:border-blue-700 transition-all duration-300">
                {{ is_object($topic) ? $topic->name : $topic }}
            </a>
        @endforeach
    </div>
</div>