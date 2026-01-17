<x-layouts::auth>
    <div class="flex flex-col gap-8">
        <x-auth-header :title="__('Set New Password')" :description="__('Almost there! Enter your email and a new strong password below to regain access to your dashboard')" />

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">
                    {{ __('Email Address') }}
                </label>
                <input type="email" id="email" name="email" value="{{ old('email', request('email')) }}" required
                    autocomplete="email"
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
                    {{ __('New Password') }}
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
                    {{ __('Confirm New Password') }}
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    autocomplete="new-password" placeholder="••••••••"
                    class="w-full px-6 py-4 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-sm font-bold placeholder-gray-300">
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-primary-600 text-white px-8 py-4 rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all shadow-xl shadow-primary-600/10 active:scale-[0.98]"
                    data-test="reset-password-button">
                    {{ __('Update Password') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>