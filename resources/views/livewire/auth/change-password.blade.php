<div class="flex flex-col gap-8 bg-white rounded-3xl shadow border border-gray-100 p-8 md:p-10">
    <!-- Header -->
    <div class="space-y-2 text-center">
        <h2 class="text-2xl font-black text-gray-900 tracking-tight">
            {{ __('Change Password') }}
        </h2>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
            {{ __('Update your password to continue') }}
        </p>
    </div>

    @if (session('status') === 'password-updated')
        <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm font-bold text-center">
            {{ __('Password updated successfully.') }}
        </div>
    @endif

    <form wire:submit="updatePassword" class="flex flex-col gap-6" x-data="{
            showCurrent: false,
            showNew: false,
            showConfirm: false,
            password: '',
            hasMinLength: false,
            hasMixedCase: false,
            hasNumber: false,
            hasSymbol: false,
            checkPassword(value) {
                if (!value) {
                    this.hasMinLength = false;
                    this.hasMixedCase = false;
                    this.hasNumber = false;
                    this.hasSymbol = false;
                    return;
                }
                this.hasMinLength = value.length >= 8;
                this.hasMixedCase = /[a-z]/.test(value) && /[A-Z]/.test(value);
                this.hasNumber = /\d/.test(value);
                this.hasSymbol = /[!@#$%^&*(),.?:;{}|<>[\]\\\/~`_+=\-]/.test(value);
            }
        }" x-init="$watch('password', value => checkPassword(value))">

        <!-- Current Password -->
        <div class="space-y-2">
            <label for="current_password"
                class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">
                {{ __('Current Password') }}
            </label>
            <div class="relative">
                <input wire:model="current_password" id="current_password" :type="showCurrent ? 'text' : 'password'"
                    required autofocus placeholder="••••••••"
                    class="w-full px-6 py-4 pr-12 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('current_password') border-error-500 ring-error-500 @enderror text-sm font-bold placeholder-gray-300">
                <button type="button" @click="showCurrent = !showCurrent"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                    <svg x-show="!showCurrent" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showCurrent" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            @error('current_password')
                <p class="text-[10px] text-error-600 font-black uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div class="space-y-2">
            <label for="password" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">
                {{ __('New Password') }}
            </label>
            <div class="relative">
                <input wire:model.live="password" x-model="password" id="password" :type="showNew ? 'text' : 'password'"
                    required placeholder="••••••••"
                    class="w-full px-6 py-4 pr-12 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('password') border-error-500 ring-error-500 @enderror text-sm font-bold placeholder-gray-300">
                <button type="button" @click="showNew = !showNew"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                    <svg x-show="!showNew" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showNew" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>

            <!-- Password Requirements -->
            <div class="ml-1 space-y-1.5" x-show="password && password.length > 0" x-cloak>
                <div class="flex items-center gap-2">
                    <svg :class="hasMinLength ? 'text-green-500' : 'text-gray-300'"
                        class="w-3.5 h-3.5 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span :class="hasMinLength ? 'text-green-600' : 'text-gray-400'"
                        class="text-[9px] font-bold uppercase tracking-wider transition-colors">At least 8
                        characters</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg :class="hasMixedCase ? 'text-green-500' : 'text-gray-300'"
                        class="w-3.5 h-3.5 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span :class="hasMixedCase ? 'text-green-600' : 'text-gray-400'"
                        class="text-[9px] font-bold uppercase tracking-wider transition-colors">Mixed case
                        letters</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg :class="hasNumber ? 'text-green-500' : 'text-gray-300'" class="w-3.5 h-3.5 transition-colors"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span :class="hasNumber ? 'text-green-600' : 'text-gray-400'"
                        class="text-[9px] font-bold uppercase tracking-wider transition-colors">Contains number</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg :class="hasSymbol ? 'text-green-500' : 'text-gray-300'" class="w-3.5 h-3.5 transition-colors"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span :class="hasSymbol ? 'text-green-600' : 'text-gray-400'"
                        class="text-[9px] font-bold uppercase tracking-wider transition-colors">Contains symbol</span>
                </div>
            </div>

            @error('password')
                <p class="text-[10px] text-error-600 font-black uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label for="password_confirmation"
                class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">
                {{ __('Confirm Password') }}
            </label>
            <div class="relative">
                <input wire:model="password_confirmation" id="password_confirmation"
                    :type="showConfirm ? 'text' : 'password'" required placeholder="••••••••"
                    class="w-full px-6 py-4 pr-12 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-sm font-bold placeholder-gray-300">
                <button type="button" @click="showConfirm = !showConfirm"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                    <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showConfirm" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full bg-primary-600 text-white px-8 py-4 rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all shadow-xl shadow-primary-600/10 active:scale-[0.98]">
                {{ __('Update Password') }}
            </button>
        </div>
    </form>

    <div class="relative py-2">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-100"></div>
        </div>
        <div class="relative flex justify-center text-sm font-medium leading-6">
            <span
                class="bg-white px-4 text-gray-300 font-black uppercase tracking-[0.2em] text-[9px]">{{ __('Or') }}</span>
        </div>
    </div>

    <div class="text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 transition">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</div>