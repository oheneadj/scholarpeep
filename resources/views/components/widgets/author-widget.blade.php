@props([
    'name',
    'avatar' => null,
    'role' => 'Reflective Blogger',
    'bio' => null,
    'location' => null,
    'socials' => [],
    'title' => 'About'
])

<div class="bg-white rounded-[2rem] p-8 md:p-10 border border-gray-100 shadow-2xl shadow-gray-200/50">
    <!-- Header Label -->
    <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-8">
        {{ $title }}
    </div>

    <!-- Profile Info -->
    <div class="flex items-center gap-5 mb-8">
        <div class="relative w-16 h-16 shrink-0">
            <!-- Vibrant Background Circle -->
            <div class="absolute inset-0 bg-gradient-to-tr from-orange-400 to-rose-600 rounded-full opacity-25 blur-sm transform scale-110"></div>
            <img src="{{ asset($avatar) ?? 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=1e3a8a&color=fff' }}" 
                 class="relative w-full h-full rounded-full object-cover border-2 border-white shadow-md" 
                 alt="{{ $name }}" loading="lazy">
        </div>
        <div>
            <h3 class="font-bold text-xl text-gray-900 leading-tight">{{ $name }}</h3>
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mt-1">{{ $role }}</p>
        </div>
    </div>

    <!-- Bio -->
    @if($bio)
        <p class="text-gray-500 text-sm leading-relaxed mb-8 font-medium">
            {{ $bio }}
        </p>
    @endif

    <!-- Location -->
    @if($location)
        <div class="flex items-center gap-3 text-gray-600 mb-10 group/loc">
            <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover/loc:bg-indigo-600 group-hover/loc:text-white transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="text-sm font-bold tracking-tight">{{ $location }}</span>
        </div>
    @endif

    <!-- Socials -->
    @if(!empty($socials))
        <div class="flex items-center gap-5">
            @foreach($socials as $platform => $url)
                <a href="{{ $url }}" target="_blank" class="text-gray-700 hover:text-primary-600 transition-colors" title="{{ ucfirst($platform) }}">
                    @if($platform === 'twitter' || $platform === 'x')
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    @elseif($platform === 'facebook')
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    @elseif($platform === 'instagram')
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    @elseif($platform === 'linkedin')
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
