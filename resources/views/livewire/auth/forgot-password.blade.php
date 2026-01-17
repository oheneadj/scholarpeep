<x-layouts::auth>
    <div class="flex flex-col gap-8">
        <x-auth-header :title="__('Reset Password')" :description="__('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.')" />

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">
                    {{ __('Email Address') }}
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-6 py-4 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('email') border-error-500 ring-error-500 @enderror text-sm font-bold placeholder-gray-300"
                    placeholder="email@example.com">
                @error('email')
                    <p class="text-[10px] text-error-600 font-black uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-primary-600 text-white px-8 py-4 rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all shadow-xl shadow-primary-600/10 active:scale-[0.98]"
                    data-test="email-password-reset-link-button">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>

        <div class="text-[10px] text-center font-black uppercase tracking-[0.2em] text-gray-400">
            <span>{{ __('Or, return to') }}</span>
            <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 transition ml-1"
                wire:navigate>
                {{ __('log in') }}
            </a>
        </div>
    </div>
</x-layouts::auth>