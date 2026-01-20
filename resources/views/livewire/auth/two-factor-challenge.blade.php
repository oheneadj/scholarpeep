<x-layouts::auth>
    <div class="flex flex-col gap-8 bg-white rounded-3xl shadow border border-gray-100 p-8 md:p-10" x-cloak x-data="{
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
        <div x-show="!showRecoveryInput" class="space-y-2">
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">{{ __('Authentication Code') }}</h1>
            <p class="text-sm text-gray-500 font-medium">
                {{ __('Enter the 6-digit authentication code provided by your authenticator app.') }}
            </p>
        </div>

        <div x-show="showRecoveryInput" class="space-y-2">
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">{{ __('Recovery Code') }}</h1>
            <p class="text-sm text-gray-500 font-medium">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('two-factor.login.store') }}" class="flex flex-col gap-6">
            @csrf

            <div class="space-y-6">
                <div x-show="!showRecoveryInput">
                    <div class="space-y-4">
                        <label for="code"
                            class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-center">
                            {{ __('Authentication Code') }}
                        </label>
                        <input type="text" id="code" name="code" x-model="code" autofocus autocomplete="one-time-code"
                            class="w-full text-center text-3xl font-black tracking-[0.5em] px-6 py-4 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('code') border-error-500 ring-error-500 @enderror placeholder-gray-200"
                            placeholder="000000" maxlength="6">
                        @error('code')
                            <p class="text-[10px] text-error-600 font-black uppercase tracking-widest mt-2 text-center">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div x-show="showRecoveryInput">
                    <div class="space-y-2">
                        <label for="recovery_code"
                            class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">
                            {{ __('Recovery Code') }}
                        </label>
                        <input type="text" id="recovery_code" name="recovery_code" x-ref="recovery_code"
                            x-bind:required="showRecoveryInput" autocomplete="one-time-code" x-model="recovery_code"
                            class="w-full px-6 py-4 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('recovery_code') border-error-500 ring-error-500 @enderror text-sm font-bold placeholder-gray-300"
                            placeholder="abcdef-12345">
                        @error('recovery_code')
                            <p class="text-[10px] text-error-600 font-black uppercase tracking-widest mt-2 ml-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-primary-600 text-white px-8 py-4 rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all shadow-xl shadow-primary-600/10 active:scale-[0.98]">
                    {{ __('Sign In') }}
                </button>
            </div>

            <div class="text-center">
                <button type="button"
                    class="text-[10px] font-black uppercase tracking-widest text-primary-600 hover:text-primary-700 transition cursor-pointer"
                    @click="toggleInput()">
                    <span x-show="!showRecoveryInput">{{ __('Use a recovery code') }}</span>
                    <span x-show="showRecoveryInput">{{ __('Use an authentication code') }}</span>
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>