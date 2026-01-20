<x-layouts::auth>
    <div class="flex flex-col gap-8 bg-white rounded-3xl shadow border border-gray-100 p-8 md:p-10">
        <div class="space-y-2">
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">{{ __('Confirm Password') }}</h1>
            <p class="text-sm text-gray-500 font-medium">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
        </div>

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Password -->
            <div class="space-y-2">
                <label for="password"
                    class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">
                    {{ __('Password') }}
                </label>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••" autofocus
                    class="w-full px-6 py-4 border border-gray-200 rounded-full focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('password') border-error-500 ring-error-500 @enderror text-sm font-bold placeholder-gray-300">
                @error('password')
                    <p class="text-[10px] text-error-600 font-black uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-primary-600 text-white px-8 py-4 rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all shadow-xl shadow-primary-600/10 active:scale-[0.98]"
                    data-test="confirm-password-button">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>