@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center space-y-1">
    <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $title }}</h1>
    <p class="text-sm text-gray-500 leading-normal">{{ $description }}</p>
</div>
