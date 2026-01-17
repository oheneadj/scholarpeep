<nav class="flex text-[10px] font-bold uppercase tracking-widest text-gray-400" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">
        <li>
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition">Dashboard</a>
            </div>
        </li>
        @if(!request()->routeIs('dashboard'))
            <li>
                <div class="flex items-center">
                    <svg class="shrink-0 h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2 text-gray-900" aria-current="page">
                        @if(request()->routeIs('profile.*')) Profile @endif
                        @if(request()->routeIs('settings.*')) Settings @endif
                    </span>
                </div>
            </li>
        @endif
    </ol>
</nav>