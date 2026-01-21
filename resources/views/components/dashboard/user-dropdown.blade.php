<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" @click.away="open = false"
        class="flex items-center gap-3 p-1 rounded-full hover:bg-gray-50 transition border border-transparent hover:border-gray-200">
        <div
            class="w-9 h-9 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-bold overflow-hidden shadow-inner">
            @if(Auth::user()->avatar)
                <img src="{{ str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar) }}"
                    alt="{{ Auth::user()->name }}" class="w-full h-full object-cover" loading="lazy">
            @else
                {{ substr(Auth::user()->name, 0, 1) }}
            @endif
        </div>
        <div class="text-left hidden lg:block">
            <p class="text-xs font-black text-gray-900 leading-tight">{{ Auth::user()->name }}</p>
            <p class="text-[10px] font-bold text-gray-400">Regular Member</p>
        </div>
        <svg class="w-4 h-4 text-gray-400 ml-1 hidden lg:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
        class="absolute right-0 mt-2 w-56 rounded-[2rem] bg-white shadow-200/50 ring-1 ring-gray-900/[0.02] overflow-hidden z-50 py-2"
        style="display: none;">

        <div class="px-4 py-3 border-b border-gray-50">
            <p class="text-xs font-black text-gray-900">{{ Auth::user()->name }}</p>
            <p class="text-[10px] font-bold text-gray-400 truncate">{{ Auth::user()->email }}</p>
        </div>

        <a href="{{ route('profile.edit') }}"
            class="block px-5 py-3 text-xs font-black uppercase tracking-widest text-gray-500 hover:bg-primary-50 hover:text-primary-700 transition mx-2 rounded-full">
            My Profile
        </a>
        <a href="{{ route('appearance.edit') }}"
            class="block px-5 py-3 text-xs font-black uppercase tracking-widest text-gray-500 hover:bg-primary-50 hover:text-primary-700 transition mx-2 rounded-full">
            Settings
        </a>

        <div class="border-t border-gray-50 mt-1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="block w-full text-left px-5 py-3 text-xs font-black uppercase tracking-widest text-rose-500 hover:bg-rose-50 transition mx-2 rounded-full">
                    Sign Out
                </button>
            </form>
        </div>
    </div>
</div>