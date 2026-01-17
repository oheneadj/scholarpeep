<div class="space-y-8" wire:cloak x-data="{ showRecoveryCodes: false }">
    <div class="space-y-2">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <h3 class="text-lg font-black font-display text-gray-900">{{ __('2FA Recovery Codes') }}</h3>
        </div>
        <p class="text-xs text-gray-500 font-bold leading-relaxed px-1">
            {{ __('Recovery codes let you regain access if you lose your 2FA device. Store them in a secure password manager.') }}
        </p>
    </div>

    <div>
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <button x-show="!showRecoveryCodes" @click="showRecoveryCodes = true;"
                class="inline-flex items-center gap-2 px-8 py-3 bg-primary-600 text-white hover:bg-primary-700 text-xs font-black uppercase tracking-widest rounded-full transition-all active:scale-95 shadow-lg shadow-primary-600/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                {{ __('View Codes') }}
            </button>

            <button x-show="showRecoveryCodes" @click="showRecoveryCodes = false"
                class="inline-flex items-center gap-2 px-8 py-3 bg-gray-900 text-white hover:bg-black text-xs font-black uppercase tracking-widest rounded-full transition-all active:scale-95 shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                </svg>
                {{ __('Hide Codes') }}
            </button>

            @if (filled($recoveryCodes))
                <button x-show="showRecoveryCodes" wire:click="regenerateRecoveryCodes"
                    class="inline-flex items-center gap-2 px-8 py-3 text-gray-500 hover:text-rose-600 font-black text-xs transition-colors uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    {{ __('Regenerate') }}
                </button>
            @endif
        </div>

        <div x-show="showRecoveryCodes" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            class="mt-8 space-y-6">
            @error('recoveryCodes')
                <div
                    class="p-4 bg-rose-50 text-rose-700 rounded-2xl border border-rose-100 text-xs font-black uppercase tracking-widest">
                    {{ $message }}
                </div>
            @enderror

            @if (filled($recoveryCodes))
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-8 bg-gray-50 rounded-[2.5rem] border border-gray-100 font-mono text-sm shadow-inner">
                    @foreach($recoveryCodes as $code)
                        <div class="p-4 bg-white border border-gray-100 rounded-2xl text-center text-gray-900 select-all font-black tracking-widest shadow-sm"
                            wire:loading.class="opacity-50">
                            {{ $code }}
                        </div>
                    @endforeach
                </div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] leading-relaxed px-4 text-center">
                    {{ __('Each recovery code can be used once. Store these safely.') }}
                </p>
            @endif
        </div>
    </div>
</div>