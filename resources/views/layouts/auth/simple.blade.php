<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    @include('partials.head')
</head>

<body class="font-sans antialiased h-full bg-gray-100 text-zinc-900">
    <div class="flex flex-col min-h-screen">
        <livewire:layout.auth-navbar />

        <main class="flex-grow flex flex-col items-center justify-center py-16 md:py-24 px-6 md:px-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    @fluxScripts
</body>

</html>