<nav x-data="{ 
    open: false,
    scrolled: false,
    atTop: true
}" 
@scroll.window="scrolled = (window.pageYOffset > 20); atTop = (window.pageYOffset <= 20)"
:class="{
    'bg-white/80 backdrop-blur-xl border-b border-gray-200/50 shadow-sm py-2': scrolled,
    'bg-white border-b border-gray-100 py-4': atTop
}"
class="sticky top-0 z-50 transition-all duration-300 ease-in-out">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-12 md:h-16">
            <div class="flex items-center gap-12">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 bg-primary-600 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-600/20 group-hover:scale-110 transition-transform duration-300 rotate-3 group-hover:rotate-0 overflow-hidden relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent"></div>
                            <svg class="w-6 h-6 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-black font-display text-gray-900 tracking-tight">Scholar<span class="text-primary-600">peep</span></span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden lg:flex items-center space-x-1">
                    @php
                        $navLinks = [
                            ['route' => 'scholarships.index', 'label' => 'Scholarships'],
                            ['route' => 'blog.index', 'label' => 'Blog', 'activePattern' => 'blog.*'],
                            ['route' => 'resources.index', 'label' => 'Resources', 'activePattern' => 'resources.*'],
                            ['route' => 'success-stories.index', 'label' => 'Success Stories', 'activePattern' => 'success-stories.*'],
                        ];
                    @endphp

                    @foreach($navLinks as $link)
                                        <a href="{{ route($link['route']) }}" wire:navigate
                                            class="relative px-4 py-2 text-sm font-bold transition-all duration-300 group
                                            {{ request()->routeIs($link['activePattern'] ?? $link['route'])
                        ? 'text-primary-600'
                        : 'text-gray-500 hover:text-gray-900' }}">
                                            <span class="relative z-10">{{ $link['label'] }}</span>
                                            @if(request()->routeIs($link['activePattern'] ?? $link['route']))
                                                <span class="absolute bottom-1 left-4 right-4 h-0.5 bg-primary-600 rounded-full"></span>
                                            @else
                                                <span class="absolute bottom-1 left-4 right-4 h-0.5 bg-primary-600 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                                            @endif
                                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden lg:flex lg:items-center lg:ml-6 gap-4">
                @auth
                    <div class="flex items-center gap-3">
                        <a href="{{ url('/dashboard') }}"
                            class="px-5 py-2.5 bg-gray-50 text-gray-900 text-sm font-bold rounded-xl hover:bg-gray-100 transition active:scale-95 border border-gray-200/50">
                            Dashboard
                        </a>

                        <div x-data="{ userOpen: false }" class="relative">
                            <button @click="userOpen = !userOpen" @click.away="userOpen = false"
                                class="flex items-center gap-2 p-1 pr-3 bg-white border border-gray-200 rounded-full hover:shadow-md transition">
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs uppercase">
                                    {{ substr(Auth::user()->name, 0, 2) }}
                                </div>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': userOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="userOpen" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-2"
                                class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-[60]"
                                style="display: none;">
                                <div class="px-4 py-2 border-b border-gray-50 mb-1">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Signed in as</p>
                                    <p class="text-sm font-black text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                </div>
                                <a href="{{ route('dashboard.documents') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-50 hover:text-primary-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    My Documents
                                </a>
                                <a href="{{ route('logout') }}" 
                                    onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-rose-500 hover:bg-rose-50 transition border-t border-gray-50 mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                    Sign Out
                                </a>
                                <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition">Login</a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center px-6 py-2.5 bg-primary-600 text-white rounded-xl font-bold text-sm hover:bg-primary-700 transition shadow-lg shadow-primary-600/20 active:scale-95">
                        Get Started
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center lg:hidden gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </a>
                @endauth
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition active:scale-90">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Overlay -->
    <div x-show="open" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="lg:hidden fixed inset-0 bg-gray-950/60 backdrop-blur-sm z-[55]" 
        style="display: none;"></div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="open" 
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="lg:hidden fixed inset-y-0 right-0 w-full max-w-xs bg-white shadow-2xl z-[60] flex flex-col"
        style="display: none;">
        
        <div class="px-6 py-6 border-b border-gray-100 flex items-center justify-between">
            <span class="text-xl font-black font-display text-gray-900 tracking-tight">Menu</span>
            <button @click="open = false" class="p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
            @foreach($navLinks as $link)
                        <a href="{{ route($link['route']) }}" wire:navigate
                            class="flex items-center gap-4 px-4 py-4 rounded-2xl text-lg font-bold transition-all
                            {{ request()->routeIs($link['activePattern'] ?? $link['route'])
                ? 'bg-primary-50 text-primary-600'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            {{ $link['label'] }}
                        </a>
            @endforeach
        </div>

        <div class="px-6 py-8 border-t border-gray-100 bg-gray-50/50">
            @auth
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-primary-600 text-white flex items-center justify-center font-black text-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-black text-gray-900 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ url('/dashboard') }}" class="flex items-center justify-center px-6 py-4 bg-white border border-gray-200 text-gray-900 font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-gray-50 transition active:scale-95 shadow-sm">
                        Dashboard
                    </a>
                    <a href="{{ route('dashboard.saved-searches') }}" class="flex items-center justify-center px-6 py-4 bg-white border border-gray-200 text-gray-900 font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-gray-50 transition active:scale-95 shadow-sm">
                        Saved Searches
                    </a>
                    <a href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                        class="flex items-center justify-center px-6 py-4 text-rose-500 font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-rose-50 transition active:scale-95">
                        Sign Out
                    </a>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </div>
            @else
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('register') }}" class="flex items-center justify-center px-6 py-4 bg-primary-600 text-white font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-primary-700 transition shadow-lg shadow-primary-600/20 active:scale-95">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="flex items-center justify-center px-6 py-4 bg-white border border-gray-200 text-gray-900 font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-gray-50 transition active:scale-95 shadow-sm">
                        Login
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>