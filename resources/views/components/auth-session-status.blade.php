@props([
    'status',
])

   @if ($status)
      <div {{ $attributes->merge(['class' => 'font-medium text-sm text-success-600 bg-success-50 border border-success-200 px-4 py-3 rounded-lg flex items-center shadow-sm']) }}>
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
            {{ $status }}
        </div>
@endif
