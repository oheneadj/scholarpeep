<section class="mt-12 bg-rose-50/50 rounded-3xl p-8 border border-rose-100">
    <div class="space-y-2 mb-8">
        <h2 class="text-xl font-black font-display text-rose-600 uppercase tracking-widest">{{ __('Danger Zone') }}</h2>
        <p class="text-sm text-gray-500 font-bold leading-relaxed">
            {{ __('Permanently delete your account and all associated data. This action cannot be undone.') }}
        </p>
    </div>

    <div x-data="{ confirming: false }">
        <button @click="confirming = true"
            class="px-8 py-3 bg-rose-600 text-white hover:bg-rose-700 text-xs font-black uppercase tracking-widest rounded-full transition-all active:scale-95 shadow-xl shadow-rose-600/10">
            {{ __('Delete My Account') }}
        </button>

        <!-- Custom Modal -->
        <div x-show="confirming"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/40 backdrop-blur-md"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-cloak style="display: none;">
            <div class="bg-white rounded-[2.5rem] shadow-200/50 w-full max-w-lg p-10 border border-gray-100"
                @click.outside="confirming = false">
                <form method="POST" wire:submit="deleteUser" class="space-y-8">
                    <div class="space-y-4 text-center">
                        <div
                            class="w-20 h-20 bg-rose-50 rounded-3xl flex items-center justify-center text-rose-600 border border-rose-100 mx-auto">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-2xl font-black font-display text-gray-900">
                                {{ __('Are you sure?') }}
                            </h3>
                            <p class="text-sm text-gray-500 font-bold leading-relaxed">
                                {{ __('Once your account is deleted, all data will be lost forever. Please enter your password to confirm.') }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="delete_password" class="block text-sm font-black text-gray-700 ml-1">
                            {{ __('Verification Password') }}
                        </label>
                        <input wire:model="password" type="password" id="delete_password" name="password"
                            placeholder="{{ __('••••••••') }}"
                            class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all font-bold">
                        @error('password')
                            <p class="text-xs text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-50">
                        <button type="button" @click="confirming = false"
                            class="flex-1 px-6 py-4 text-sm font-black text-gray-500 hover:text-gray-900 transition-colors uppercase tracking-widest">
                            {{ __('Go Back') }}
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-4 bg-rose-600 text-white rounded-full font-black text-sm uppercase tracking-widest hover:bg-rose-700 focus:outline-none focus:ring-4 focus:ring-rose-500/50 transition-all active:scale-95 shadow-xl shadow-rose-600/10">
                            {{ __('Delete Forever') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>