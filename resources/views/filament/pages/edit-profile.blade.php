<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Profile Information Section --}}
        <x-filament::section>
            <x-slot name="heading">
                Profile Information
            </x-slot>

            <x-slot name="description">
                Update your account's profile information and email address.
            </x-slot>

            <form wire:submit="updateProfile">
                {{ $this->profileForm }}

                <div class="mt-6">
                    <x-filament::button type="submit">
                        Save Profile
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- Account Information --}}
        <x-filament::section>
            <x-slot name="heading">
                Account Information
            </x-slot>

            <x-slot name="description">
                View your account details and role.
            </x-slot>

            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        <x-filament::badge :color="auth()->user()->role->getColor()">
                            {{ auth()->user()->role->getLabel() }}
                        </x-filament::badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Status</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        <x-filament::badge :color="auth()->user()->is_active ? 'success' : 'danger'">
                            {{ auth()->user()->is_active ? 'Active' : 'Inactive' }}
                        </x-filament::badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        {{ auth()->user()->created_at->format('F j, Y') }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Login</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        {{ auth()->user()->last_login_date ? auth()->user()->last_login_date->format('F j, Y') : 'Never' }}
                    </dd>
                </div>
            </dl>
        </x-filament::section>

        {{-- Update Password Section --}}
        <x-filament::section>
            <x-slot name="heading">
                Update Password
            </x-slot>

            <x-slot name="description">
                Ensure your account is using a long, random password to stay secure.
            </x-slot>

            <form wire:submit="updatePassword">
                {{ $this->passwordForm }}

                <div class="mt-6">
                    <x-filament::button type="submit" color="primary">
                        Update Password
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>
    </div>
</x-filament-panels::page>