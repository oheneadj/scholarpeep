@props(['topics', 'title' => 'Explore Topics', 'bg' => 'bg-gray-50'])

<div class="{{ $bg }} rounded-[2rem] p-8 border border-gray-100/50 shadow-sm">
    <h3 class="font-bold text-gray-900 font-display mb-6">{{ $title }}</h3>
    <div class="flex flex-wrap gap-2">
        @foreach($topics as $topic)
            <a href="{{ is_object($topic) ? '#' : '#' }}"
                class="px-4 py-2 bg-white rounded-xl text-xs font-bold text-gray-600 shadow-sm border border-gray-100 hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-all duration-300">
                {{ is_object($topic) ? $topic->name : $topic }}
            </a>
        @endforeach
    </div>
</div>