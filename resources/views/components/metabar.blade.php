@props([
    'title',
    'readingTime' => null,
    'scrolledPercentage' => 'scrolledPercentage',
    'isSaved' => false,
    'showSave' => true
])

<div {{ $attributes->merge(['class' => 'hidden lg:flex lg:col-span-1 sticky top-32 flex-col items-center gap-10']) }} 
     x-data="{ 
        copied: false,
        copyToClipboard() {
            navigator.clipboard.writeText(window.location.href);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
     }">
    
    @if($readingTime)
        <!-- Reading Time -->
        <div class="relative flex flex-col items-center group">
            <div class="w-16 h-16 rounded-full bg-white shadow-xl shadow-gray-900/5 flex flex-col items-center justify-center relative z-10 border border-gray-100">
                <span class="text-[9px] font-black text-gray-900 leading-[1.1] text-center uppercase tracking-tighter">{{ $readingTime }} min<br>read</span>
                <!-- Progress Ring -->
                <div class="absolute inset-0 -m-1">
                    <svg class="w-[72px] h-[72px] -rotate-90">
                        <circle class="text-gray-100/50" stroke-width="2" stroke="currentColor" fill="none" r="34" cx="36" cy="36"/>
                        <circle class="text-primary-600 transition-all duration-300" stroke-width="2" :stroke-dasharray="213.6" :stroke-dashoffset="213.6 * (1 - {{ $scrolledPercentage }} / 100)" stroke-linecap="round" stroke="currentColor" fill="none" r="34" cx="36" cy="36"/>
                    </svg>
                </div>
            </div>
        </div>
    @endif

    <!-- Share Vertical List -->
    <div class="flex flex-col items-center gap-6">
        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($title) }}" target="_blank" class="text-gray-400 hover:text-gray-950 transition-colors" title="Share on X">
             <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="text-gray-400 hover:text-gray-950 transition-colors" title="Share on Facebook">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </a>
        <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(request()->url()) }}&title={{ urlencode($title) }}" target="_blank" class="text-gray-400 hover:text-gray-950 transition-colors" title="Share on LinkedIn">
             <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
        </a>
        <button @click="copyToClipboard" class="text-gray-400 hover:text-gray-950 transition-colors relative" title="Copy Link">
            <svg x-show="!copied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <svg x-show="copied" x-cloak class="w-5 h-5 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </button>
    </div>

    @if($showSave)
        <!-- Quick Save Shortcut -->
        <div class="flex flex-col items-center gap-4">
            <div class="w-px h-8 bg-gray-100"></div>
            <button wire:click="toggleSave" class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 {{ $isSaved ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/30' : 'bg-white border border-gray-100 text-gray-400 hover:text-primary-600 hover:border-primary-200 shadow-sm' }}" title="{{ $isSaved ? 'Unsave' : 'Save for Later' }}">
                <svg class="w-5 h-5" fill="{{ $isSaved ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
            </button>
        </div>
    @endif
</div>
