<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <x-settings.layout :heading="__('Profile Information')" :subheading="__('Update your account\'s profile information and email address.')">
        <form wire:submit="updateProfileInformation" class="space-y-8">
            {{-- Avatar Section --}}
            <div
                class="bg-white rounded-3xl shadow-200/50 p-8 border border-gray-100 flex flex-col sm:flex-row items-center gap-8 relative overflow-hidden">
                {{-- Stats Overlay Background or subtle detail --}}
                <div class="absolute top-0 right-0 p-8 opacity-[0.03] pointer-events-none">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>

                <div class="relative group">
                    <div
                        class="w-32 h-32 rounded-3xl bg-primary-100 border-4 border-white shadow-xl overflow-hidden flex items-center justify-center text-primary-600 shadow-primary-600/10">
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($currentAvatar)
                            <img src="{{ str_starts_with($currentAvatar, 'http') ? $currentAvatar : asset('storage/' . $currentAvatar) }}"
                                class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl font-black uppercase tracking-tighter">{{ substr($name, 0, 1) }}</span>
                        @endif

                        {{-- Loading Overlay --}}
                        <div wire:loading wire:target="avatar"
                            class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center">
                            <svg class="animate-spin h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <label for="avatar-upload"
                        class="absolute -bottom-2 -right-2 w-10 h-10 bg-primary-600 text-white rounded-xl flex items-center justify-center cursor-pointer shadow-lg shadow-primary-600/20 hover:bg-primary-700 transition active:scale-95 group-hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <input type="file" id="avatar-upload" wire:model="avatar" class="hidden" accept="image/*">
                    </label>
                </div>

                <div class="flex-1 text-center sm:text-left">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-xl font-black text-gray-900 mb-1 tracking-tight">Profile Photo</h3>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Member since
                                {{ $this->stats['joined_at'] }}</p>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-center sm:text-left">
                                <p class="text-2xl font-black text-gray-900 font-display leading-tight">
                                    {{ $this->stats['saved'] }}</p>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Saved</p>
                            </div>
                            <div class="w-px h-8 bg-gray-100"></div>
                            <div class="text-center sm:text-left">
                                <p class="text-2xl font-black text-primary-600 font-display leading-tight">
                                    {{ $this->stats['applied'] }}</p>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Applied</p>
                            </div>
                        </div>
                    </div>

                    @error('avatar')
                        <p class="text-xs text-rose-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Fields --}}
            <div class="bg-white rounded-3xl shadow-200/50 p-8 border border-gray-100 space-y-6">
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label for="name" class="block text-sm font-bold text-gray-700 ml-1">
                            {{ __('Name') }}
                        </label>
                        <input wire:model="name" type="text" id="name" name="name" required
                            class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all font-bold">
                        @error('name')
                            <p class="text-xs text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-bold text-gray-700 ml-1">
                            {{ __('Email Address') }}
                        </label>
                        <input wire:model="email" type="email" id="email" name="email" required
                            class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all font-bold">
                        @error('email')
                            <p class="text-xs text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror

                        @if ($this->hasUnverifiedEmail)
                            <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                                <p class="text-xs text-amber-800 font-bold">
                                    {{ __('Email unverified.') }}
                                    <button type="button"
                                        class="text-primary-600 hover:text-primary-700 font-black ml-1 transition"
                                        wire:click.prevent="resendVerificationNotification">
                                        {{ __('Resend link') }}
                                    </button>
                                </p>
                            </div>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-xs font-black text-success-600 uppercase tracking-widest ml-1">
                                    {{ __('Verification link sent.') }}
                                </p>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-50">
                    <button type="submit"
                        class="px-8 py-4 bg-primary-600 text-white rounded-full font-black text-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all active:scale-95 shadow-xl shadow-primary-600/10">
                        {{ __('Save Changes') }}
                    </button>

                    <x-action-message class="text-xs font-black text-success-600 uppercase tracking-widest"
                        on="profile-updated">
                        {{ __('Updated!') }}
                    </x-action-message>
                </div>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <div class="mt-12">
                <livewire:settings.delete-user-form />
            </div>
        @endif
    </x-settings.layout>
</div>