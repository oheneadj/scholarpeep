<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <x-settings.layout
        :heading="__('Two-Factor Authentication')"
        :subheading="__('Add an extra layer of security to your account using TOTP.')"
    >
        <div class="flex flex-col w-full mx-auto space-y-8" wire:cloak>
            @if ($twoFactorEnabled)
                <div class="bg-white rounded-3xl shadow-200/50 p-8 border border-gray-100 space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 bg-success-50 text-success-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-success-100 flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-success-500 animate-pulse"></div>
                            {{ __('Active') }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 font-bold leading-relaxed max-w-lg">
                        {{ __('With two-factor authentication enabled, you will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.') }}
                    </p>

                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <livewire:settings.two-factor.recovery-codes :$requiresConfirmation/>
                    </div>

                    <div class="flex justify-start pt-4 border-t border-gray-50">
                        <button
                            wire:click="disable"
                            class="inline-flex items-center gap-2 px-8 py-4 bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-black uppercase tracking-widest rounded-full transition-all active:scale-95"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ __('Disable 2FA') }}
                        </button>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-200/50 p-8 border border-gray-100 space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 bg-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-gray-200">
                            {{ __('Inactive') }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 font-bold leading-relaxed max-w-lg">
                        {{ __('When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported application on your phone.') }}
                    </p>

                    <div class="pt-4">
                        <button
                            wire:click="enable"
                            class="inline-flex items-center gap-2 px-10 py-4 bg-primary-600 text-white hover:bg-primary-700 text-sm font-black uppercase tracking-widest rounded-full shadow-xl shadow-primary-600/10 transition-all active:scale-95"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            {{ __('Enable 2FA') }}
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </x-settings.layout>

    <!-- Modal implementation -->
    @if($showModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/40 backdrop-blur-md" x-data>
        <div class="bg-white rounded-[2.5rem] shadow-200/50 w-full max-w-md p-10 border border-gray-100 animate-in fade-in zoom-in duration-300" @click.outside="$wire.set('showModal', false)">
            <div class="space-y-8">
                <div class="flex flex-col items-center space-y-6">
                    <div class="p-4 bg-primary-50 rounded-3xl border border-primary-100 shadow-inner">
                        <div class="p-3 bg-white rounded-2xl border border-gray-100">
                             <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 8h16M4 16h16M4 12h16M4 12v4m0-8v4m0 0h16"/></svg>
                        </div>
                    </div>

                    <div class="space-y-2 text-center">
                        <h2 class="text-2xl font-black font-display text-gray-900 leading-tight">{{ $this->modalConfig['title'] }}</h2>
                        <p class="text-sm text-gray-500 font-bold leading-relaxed px-4">{{ $this->modalConfig['description'] }}</p>
                    </div>
                </div>

                @if ($showVerificationStep)
                    <div class="space-y-8">
                        <div class="flex flex-col items-center space-y-4">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Verification Code') }}</label>
                            <input 
                                wire:model="code"
                                type="text"
                                maxlength="6"
                                placeholder="000000"
                                class="w-full text-center text-4xl font-black tracking-[0.4em] px-4 py-6 bg-gray-50 border-gray-200 rounded-3xl focus:bg-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all font-display placeholder:text-gray-200"
                            />
                        </div>

                        <div class="flex items-center gap-4 pt-4 border-t border-gray-50">
                            <button
                                wire:click="resetVerification"
                                class="flex-1 py-4 text-sm font-black text-gray-500 hover:text-gray-900 transition uppercase tracking-widest"
                            >
                                {{ __('Back') }}
                            </button>

                            <button
                                wire:click="confirmTwoFactor"
                                class="flex-1 py-4 bg-primary-600 text-white rounded-full font-black text-sm uppercase tracking-widest hover:bg-primary-700 transition disabled:opacity-50 shadow-xl shadow-primary-600/10"
                                :disabled="$wire.code.length < 6"
                            >
                                {{ __('Verify') }}
                            </button>
                        </div>
                    </div>
                @else
                    @error('setupData')
                        <div class="p-4 bg-rose-50 text-rose-700 rounded-2xl border border-rose-100 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-xs font-black uppercase tracking-wider">{{ $message }}</p>
                        </div>
                    @enderror

                    <div class="flex justify-center">
                        <div class="relative w-64 p-6 bg-white overflow-hidden border-4 border-gray-50 rounded-[2.5rem] aspect-square flex items-center justify-center shadow-inner">
                            @empty($qrCodeSvg)
                                <div class="animate-pulse flex flex-col items-center gap-4 text-gray-300">
                                    <svg class="w-12 h-12 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-center">Generating<br>Secure QR...</p>
                                </div>
                            @else
                                <div class="w-full">
                                    {!! $qrCodeSvg !!}
                                </div>
                            @endempty
                        </div>
                    </div>

                    <button
                        :disabled="$errors->has('setupData')"
                        wire:click="showVerificationIfNecessary"
                        class="w-full py-5 bg-primary-600 text-white rounded-full font-black text-sm uppercase tracking-widest hover:bg-primary-700 transition shadow-xl shadow-primary-600/10 disabled:opacity-50"
                    >
                        {{ $this->modalConfig['buttonText'] }}
                    </button>

                    <div class="space-y-6 pt-4">
                        <div class="relative flex items-center justify-center w-full">
                            <div class="absolute inset-0 w-full h-px top-1/2 bg-gray-100"></div>
                            <span class="relative px-4 text-[10px] font-black uppercase tracking-widest bg-white text-gray-400">
                                {{ __('Manual Verification') }}
                            </span>
                        </div>

                        <div
                            class="flex items-center space-x-2"
                            x-data="{
                                copied: false,
                                async copy() {
                                    try {
                                        await navigator.clipboard.writeText('{{ $manualSetupKey }}');
                                        this.copied = true;
                                        setTimeout(() => this.copied = false, 1500);
                                    } catch (e) {
                                        console.warn('Could not copy to clipboard');
                                    }
                                }
                            }"
                        >
                            <div class="flex items-stretch w-full border border-gray-200 rounded-3xl overflow-hidden bg-gray-50/50">
                                @empty($manualSetupKey)
                                    <div class="flex items-center justify-center w-full p-6">
                                        <svg class="w-5 h-5 text-gray-300 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </div>
                                @else
                                    <input
                                        type="text"
                                        readonly
                                        value="{{ $manualSetupKey }}"
                                        class="w-full px-6 py-5 bg-transparent outline-none text-gray-900 font-mono text-sm tracking-widest"
                                    />

                                    <button
                                        @click="copy()"
                                        class="px-6 group border-l border-gray-100 hover:bg-white transition-colors"
                                    >
                                        <svg x-show="!copied" class="w-5 h-5 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
                                        <svg x-show="copied" class="w-5 h-5 text-success-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </button>
                                @endempty
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
