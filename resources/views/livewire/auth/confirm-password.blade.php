<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Confirm Password')" :description="__('This is a secure area of the application. Please confirm your password before continuing to ensure your account security.')" />

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Password -->
            <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    {{ __('Password') }}
                </label>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••" autofocus
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('password') border-error-500 ring-error-500 @enderror">
                @error('password')
                    <p class="text-xs text-error-600 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-primary-600 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all shadow-sm hover:shadow active:scale-[0.98]"
                    data-test="confirm-password-button">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>