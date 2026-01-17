@props(['faq'])

<div x-data="{ expanded: false }"
    class="bg-white rounded-2xl border-2 border-blue-300 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
    <button @click="expanded = !expanded" class="w-full flex items-center justify-between p-6 text-left">
        <h3 class="font-bold text-gray-900 text-lg pr-8">{{ $faq->question }}</h3>
        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center transition-transform duration-300"
            :class="expanded ? 'rotate-180 bg-blue-50 text-blue-600' : 'text-gray-400'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </button>
    <div x-show="expanded" x-collapse>
        <div class="px-6 pb-6 pt-0 text-gray-600 leading-relaxed prose prose-primary max-w-none">
            {!! $faq->answer !!}
        </div>
    </div>
</div>