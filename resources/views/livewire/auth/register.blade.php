<x-layouts::auth>
    <div class="flex flex-col gap-8">
        <x-auth-header :title="__('Create an account')" :description="__('Join Scholarpeep to start tracking and applying for life-changing scholarships')" />

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">
                    {{ __('Full Name') }}
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name"
                    class="w-full px-6 py-4 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('name') border-error-500 ring-error-500 @enderror text-sm font-bold placeholder-gray-300"
                    placeholder="John Doe">
                @error('name')
                    <p class="text-[10px] text-error-600 font-black uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">
                    {{ __('Email address') }}
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    class="w-full px-6 py-4 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('email') border-error-500 ring-error-500 @enderror text-sm font-bold placeholder-gray-300"
                    placeholder="email@example.com">
                @error('email')
                    <p class="text-[10px] text-error-600 font-black uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password"
                    class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">
                    {{ __('Password') }}
                </label>
                <input type="password" id="password" name="password" required autocomplete="new-password"
                    placeholder="••••••••"
                    class="w-full px-6 py-4 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('password') border-error-500 ring-error-500 @enderror text-sm font-bold placeholder-gray-300">
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
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    autocomplete="new-password" placeholder="••••••••"
                    class="w-full px-6 py-4 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-sm font-bold placeholder-gray-300">
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-primary-600 text-white px-8 py-4 rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all shadow-xl shadow-primary-600/10 active:scale-[0.98]">
                    {{ __('Create Account') }}
                </button>
            </div>
        </form>

        <div class="relative py-2">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-100"></div>
            </div>
            <div class="relative flex justify-center text-sm font-medium leading-6">
                <span
                    class="bg-[#f9fafb] px-4 text-gray-300 font-black uppercase tracking-[0.2em] text-[9px]">{{ __('Fast Onboarding') }}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('socialite.redirect', ['provider' => 'google']) }}"
                class="flex w-full items-center justify-center gap-3 rounded-full bg-white px-4 py-3 text-xs font-black uppercase tracking-widest text-gray-900 shadow-sm border border-gray-100 hover:bg-gray-50 transition-all active:scale-[0.98]">
                <svg class="h-4 w-4" viewBox="0 0 24 24">
                    <path
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                        fill="#4285F4" />
                    <path
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                        fill="#34A853" />
                    <path
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
                        fill="#FBBC05" />
                    <path
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                        fill="#EA4335" />
                </svg>
                <span>Google</span>
            </a>

            <a href="{{ route('socialite.redirect', ['provider' => 'linkedin']) }}"
                class="flex w-full items-center justify-center gap-3 rounded-full bg-white px-4 py-3 text-xs font-black uppercase tracking-widest text-gray-900 shadow-sm border border-gray-100 hover:bg-gray-50 transition-all active:scale-[0.98]">
                <svg class="h-4 w-4 text-[#0077b5]" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                </svg>
                <span>LinkedIn</span>
            </a>
        </div>

        <div class="text-[10px] text-center font-black uppercase tracking-[0.2em] text-gray-400">
            <span>{{ __('Already have an account?') }}</span>
            <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 transition ml-1"
                wire:navigate>
                {{ __('Log in') }}
            </a>
        </div>
    </div>
</x-layouts::auth>