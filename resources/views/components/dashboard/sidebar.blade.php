<div class="flex-1 flex flex-col min-h-0 bg-white">
    <!-- Logo -->
    <div class="flex items-center h-16 shrink-0 px-6 border-b border-gray-100">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
            </div>
            <span class="text-xl font-bold font-outfit text-zinc-900 tracking-tight">Scholarpeep</span>
        </a>
    </div>

    <!-- Navigation -->
    <div class="flex-1 flex flex-col overflow-y-auto py-6">
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="group flex items-center px-4 py-3 text-sm font-bold rounded-full transition {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 shrink-0 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Scholarship Pipeline
            </a>

            <a href="{{ route('dashboard.saved-resources') }}"
                class="group flex items-center px-4 py-3 text-sm font-bold rounded-full transition {{ request()->routeIs('dashboard.saved-resources') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 shrink-0 h-5 w-5 {{ request()->routeIs('dashboard.saved-resources') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
                Saved Resources
            </a>

            <a href="{{ route('profile.edit') }}"
                class="group flex items-center px-4 py-3 text-sm font-bold rounded-full transition {{ request()->routeIs('profile.*') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 shrink-0 h-5 w-5 {{ request()->routeIs('profile.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                My Profile
            </a>

            <a href="{{ route('preferences.edit') }}"
                class="group flex items-center px-4 py-3 text-sm font-bold rounded-full transition {{ request()->routeIs('preferences.edit') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 shrink-0 h-5 w-5 {{ request()->routeIs('preferences.edit') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                Preferences
            </a>

            <a href="{{ route('notifications.edit') }}"
                class="group flex items-center px-4 py-3 text-sm font-bold rounded-full transition {{ request()->routeIs('notifications.edit') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 shrink-0 h-5 w-5 {{ request()->routeIs('notifications.edit') ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Notifications
            </a>
        </nav>
    </div>

    <!-- User Section Bottom -->
    <div class="shrink-0 flex border-t border-gray-100 p-4">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit"
                class="group flex items-center w-full px-4 py-3 text-sm font-bold text-gray-500 rounded-full hover:bg-rose-50 hover:text-rose-600 transition">
                <svg class="mr-3 shrink-0 h-5 w-5 text-gray-400 group-hover:text-rose-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Log Out
            </button>
        </form>
    </div>
</div>