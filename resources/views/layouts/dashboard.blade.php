<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Scholarpeep') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased h-full text-zinc-900 overflow-hidden" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden bg-gray-50">
        <!-- Desktop Sidebar -->
        <div class="hidden md:flex md:shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200">
                <x-dashboard.sidebar />
            </div>
        </div>

        <!-- Mobile Sidebar (Drawer) -->
        <div x-show="sidebarOpen" class="fixed inset-0 flex z-50 md:hidden" style="display: none;"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div @click="sidebarOpen = false" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                class="relative flex-1 flex flex-col max-w-xs w-full bg-white">

                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false"
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <x-dashboard.sidebar />
            </div>

            <div class="shrink-0 w-14" aria-hidden="true"></div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation / Header -->
            <header class="bg-white border-b border-gray-200 shrink-0 z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = true"
                            class="md:hidden p-2 -ml-2 text-gray-400 hover:text-gray-500 rounded-xl hover:bg-gray-100 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <x-dashboard.breadcrumbs />
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('home') }}"
                            class="text-xs font-bold text-gray-500 hover:text-primary-600 transition hidden sm:block">Back
                            to Site</a>
                        <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>
                        <x-dashboard.user-dropdown />
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto focus:outline-none bg-gray-50/50">
                {{ $slot }}
            </main>
        </div>
    </div>

    <x-notification />
    @livewireScripts
</body>

</html>