<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <div class="relative w-full h-auto" x-cloak x-data="{
                showRecoveryInput: @js($errors->has('recovery_code')),
                code: '',
                recovery_code: '',
                toggleInput() {
                    this.showRecoveryInput = !this.showRecoveryInput;

                    this.code = '';
                    this.recovery_code = '';

                    $dispatch('clear-2fa-auth-code');

                    $nextTick(() => {
                        this.showRecoveryInput
                            ? this.$refs.recovery_code?.focus()
                            : $dispatch('focus-2fa-auth-code');
                    });
                },
            }">
            <div x-show="!showRecoveryInput">
                <x-auth-header :title="__('Authentication Code')" :description="__('Enter the 6-digit authentication code provided by your authenticator app')" />
            </div>

            <div x-show="showRecoveryInput">
                <x-auth-header :title="__('Recovery Code')" :description="__('Please confirm access to your account by entering one of your emergency recovery codes')" />
            </div>

            <form method="POST" action="{{ route('two-factor.login.store') }}" class="mt-6 flex flex-col gap-5">
                @csrf

                <div>
                    <div x-show="!showRecoveryInput">
                        <div class="space-y-1">
                            <label for="code" class="block text-sm font-medium text-gray-700 text-center mb-2">
                                {{ __('Authentication Code') }}
                            </label>
                            <input type="text" id="code" name="code" x-model="code" autofocus
                                autocomplete="one-time-code"
                                class="w-full text-center text-2xl tracking-[0.5em] px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('code') border-error-500 ring-error-500 @enderror"
                                placeholder="000000" maxlength="6">
                            @error('code')
                                <p class="text-xs text-error-600 font-medium mt-1 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div x-show="showRecoveryInput">
                        <div class="space-y-1">
                            <label for="recovery_code" class="block text-sm font-medium text-gray-700">
                                {{ __('Recovery Code') }}
                            </label>
                            <input type="text" id="recovery_code" name="recovery_code" x-ref="recovery_code"
                                x-bind:required="showRecoveryInput" autocomplete="one-time-code" x-model="recovery_code"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('recovery_code') border-error-500 ring-error-500 @enderror"
                                placeholder="abcdef-12345">
                            @error('recovery_code')
                                <p class="text-xs text-error-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-primary-600 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all shadow-sm active:scale-[0.98]">
                        {{ __('Sign In') }}
                    </button>
                </div>

                <div class="text-sm text-center">
                    <button type="button"
                        class="text-primary-600 hover:text-primary-700 font-medium transition cursor-pointer"
                        @click="toggleInput()">
                        <span x-show="!showRecoveryInput">{{ __('Use a recovery code') }}</span>
                        <span x-show="showRecoveryInput">{{ __('Use an authentication code') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::auth>