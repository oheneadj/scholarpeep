<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <x-settings.layout :heading="__('Update Password')" :subheading="__('Ensure your account is using a long, random password to stay secure.')">
        <form wire:submit="updatePassword" class="space-y-6">
            <div class="bg-white rounded-3xl shadow-200/50 p-8 border border-gray-100 space-y-6">
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label for="current_password" class="block text-sm font-bold text-gray-700 ml-1">
                            {{ __('Current Password') }}
                        </label>
                        <input wire:model="current_password" type="password" id="current_password"
                            name="current_password"
                            class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all font-bold">
                        @error('current_password')
                            <p class="text-xs text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-bold text-gray-700 ml-1">
                            {{ __('New Password') }}
                        </label>
                        <input wire:model="password" type="password" id="password" name="password"
                            class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all font-bold">
                        @error('password')
                            <p class="text-xs text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 ml-1">
                            {{ __('Confirm Password') }}
                        </label>
                        <input wire:model="password_confirmation" type="password" id="password_confirmation"
                            name="password_confirmation"
                            class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all font-bold">
                        @error('password_confirmation')
                            <p class="text-xs text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-50">
                    <button type="submit"
                        class="px-8 py-4 bg-primary-600 text-white rounded-full font-black text-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all active:scale-95 shadow-xl shadow-primary-600/10">
                        {{ __('Update Password') }}
                    </button>

                    <x-action-message class="text-xs font-black text-success-600 uppercase tracking-widest"
                        on="password-updated">
                        {{ __('Changed!') }}
                    </x-action-message>
                </div>
            </div>
        </form>
    </x-settings.layout>
</div>