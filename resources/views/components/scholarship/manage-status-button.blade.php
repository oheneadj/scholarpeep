@props(['id', 'label' => null])

<button wire:click="$dispatch('open-status-update', { id: {{ $id }} })" {{ $attributes->merge(['class' => 'rounded-xl flex items-center justify-center transition duration-300 ' . ($label ? 'px-3 py-1.5 gap-2 bg-gray-50 text-gray-500 hover:bg-primary-50 hover:text-primary-600 text-xs font-bold' : 'w-10 h-10 bg-gray-50 text-gray-400 hover:bg-primary-50 hover:text-primary-600')]) }} title="Manage Status">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    @if($label)
        <span>{{ $label }}</span>
    @endif
</button>