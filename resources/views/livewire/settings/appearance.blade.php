<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Customize how Scholarpeep looks on your device.')">
        <div class="bg-white rounded-3xl shadow-200/50 p-8 border border-gray-100">
            <div class="bg-gray-50 p-2 rounded-full inline-flex gap-2" x-data="{ appearance: 'light' }">
                <button @click="appearance = 'light'"
                    :class="appearance === 'light' ? 'bg-white text-primary-700 shadow-lg' : 'text-gray-500 hover:text-gray-900'"
                    class="px-8 py-3 text-xs font-black uppercase tracking-widest rounded-full transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    {{ __('Light') }}
                </button>
                <button @click="appearance = 'dark'"
                    :class="appearance === 'dark' ? 'bg-white text-primary-700 shadow-lg' : 'text-gray-500 hover:text-gray-900'"
                    class="px-8 py-3 text-xs font-black uppercase tracking-widest rounded-full transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    {{ __('Dark') }}
                </button>
                <button @click="appearance = 'system'"
                    :class="appearance === 'system' ? 'bg-white text-primary-700 shadow-lg' : 'text-gray-500 hover:text-gray-900'"
                    class="px-8 py-3 text-xs font-black uppercase tracking-widest rounded-full transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ __('System') }}
                </button>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-50">
                <p class="text-xs font-bold text-gray-400 italic">Theme settings are currently saved locally to your
                    browser.</p>
            </div>
        </div>
    </x-settings.layout>
</div>