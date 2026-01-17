<div class="flex flex-col lg:flex-row items-start lg:gap-14">
    {{-- Internal Navigation --}}
    <div class="w-full lg:w-72 shrink-0">
        <nav class="space-y-1 bg-white p-3 rounded-[2rem] shadow-200/50 border border-gray-100">
            <a href="{{ route('profile.edit') }}" wire:navigate
                class="flex items-center px-5 py-4 text-sm font-black uppercase tracking-widest rounded-full transition-all {{ request()->routeIs('profile.edit') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                {{ __('Profile') }}
            </a>
            <a href="{{ route('user-password.edit') }}" wire:navigate
                class="flex items-center px-5 py-4 text-sm font-black uppercase tracking-widest rounded-full transition-all {{ request()->routeIs('user-password.edit') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                {{ __('Password') }}
            </a>
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <a href="{{ route('two-factor.show') }}" wire:navigate
                    class="flex items-center px-5 py-4 text-sm font-black uppercase tracking-widest rounded-full transition-all {{ request()->routeIs('two-factor.show') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    <svg class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    {{ __('Two-Factor') }}
                </a>
            @endif
            <a href="{{ route('appearance.edit') }}" wire:navigate
                class="flex items-center px-5 py-4 text-sm font-black uppercase tracking-widest rounded-full transition-all {{ request()->routeIs('appearance.edit') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-3" />
                </svg>
                {{ __('Appearance') }}
            </a>
            <a href="{{ route('preferences.edit') }}" wire:navigate
                class="flex items-center px-5 py-4 text-sm font-black uppercase tracking-widest rounded-full transition-all {{ request()->routeIs('preferences.edit') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                {{ __('Preferences') }}
            </a>
            <a href="{{ route('notifications.edit') }}" wire:navigate
                class="flex items-center px-5 py-4 text-sm font-black uppercase tracking-widest rounded-full transition-all {{ request()->routeIs('notifications.edit') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg class="mr-4 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                {{ __('Notifications') }}
            </a>
        </nav>
    </div>

    {{-- Content --}}
    <div class="flex-1 w-full max-w-5xl">
        <div class="mb-10 lg:pl-1">
            <h2 class="text-3xl font-black font-display text-gray-900 mb-2 tracking-tight">{{ $heading ?? '' }}</h2>
            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-[0.2em]">{{ $subheading ?? '' }}</p>
        </div>

        <div class="w-full space-y-8">
            {{ $slot }}
        </div>
    </div>
</div>