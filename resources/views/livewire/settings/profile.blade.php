<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight font-display mb-2">Profile Information</h1>
        <p class="text-gray-500 font-medium truncate">Update your account's profile information and email address.</p>
    </div>

    <form wire:submit="updateProfileInformation" class="space-y-8">
        {{-- Avatar & Stats Section --}}
        <div
            class="bg-white rounded-[2.5rem] shadow-200/50 p-8 border border-gray-100 flex flex-col md:flex-row items-center gap-10 relative overflow-hidden group/card shadow-xl shadow-gray-200/20">
            {{-- Decorative pattern --}}
            <div
                class="absolute -top-10 -right-10 w-40 h-40 bg-primary-50 rounded-full opacity-30 blur-3xl group-hover/card:bg-primary-100 transition-colors">
            </div>

            <div class="relative">
                <div
                    class="w-40 h-40 rounded-[2.5rem] bg-gradient-to-br from-primary-50 to-primary-100 border-4 border-white shadow-2xl overflow-hidden flex items-center justify-center text-primary-600 transition-transform duration-500 hover:scale-105">
                    @if ($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                    @elseif ($currentAvatar)
                        <img src="{{ str_starts_with($currentAvatar, 'http') ? $currentAvatar : asset('storage/' . $currentAvatar) }}"
                            class="w-full h-full object-cover">
                    @else
                        <span class="text-5xl font-black uppercase tracking-tighter">{{ substr($name, 0, 1) }}</span>
                    @endif

                    {{-- Loading Overlay --}}
                    <div wire:loading wire:target="avatar"
                        class="absolute inset-0 bg-white/60 backdrop-blur-md flex items-center justify-center">
                        <svg class="animate-spin h-10 w-10 text-primary-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>

                <label for="avatar-upload"
                    class="absolute -bottom-2 -right-2 w-12 h-12 bg-primary-600 text-white rounded-2xl flex items-center justify-center cursor-pointer shadow-xl shadow-primary-600/30 hover:bg-primary-700 hover:scale-110 active:scale-95 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <input type="file" id="avatar-upload" wire:model="avatar" class="hidden" accept="image/*">
                </label>
            </div>

            <div class="flex-1 text-center md:text-left space-y-6">
                <div>
                    <h3 class="text-2xl font-black text-gray-900 mb-1 tracking-tight font-display">
                        {{ $name }}
                    </h3>
                    <div class="flex items-center justify-center md:justify-start gap-2">
                        <span
                            class="px-3 py-1 bg-primary-50 text-primary-600 text-[10px] font-black uppercase tracking-widest rounded-full">
                            Student Member
                        </span>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                            Joined {{ $this->stats['joined_at'] }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-center md:justify-start gap-12">
                    <div class="group/stat">
                        <p
                            class="text-3xl font-black text-gray-900 font-display leading-tight group-hover/stat:text-primary-600 transition-colors">
                            {{ $this->stats['saved'] }}
                        </p>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Saved</p>
                    </div>
                    <div class="w-px h-10 bg-gray-100 hidden sm:block"></div>
                    <div class="group/stat">
                        <p
                            class="text-3xl font-black text-primary-600 font-display leading-tight group-hover/stat:scale-110 transition-transform origin-left">
                            {{ $this->stats['applied'] }}
                        </p>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Applied</p>
                    </div>
                </div>

                @error('avatar')
                    <p class="text-xs text-rose-500 font-bold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Personal Details --}}
        <div
            class="bg-white rounded-[2.5rem] shadow-200/50 p-10 border border-gray-100 space-y-8 shadow-xl shadow-gray-200/20">
            <h4 class="text-xl font-black text-gray-900 font-display">Personal Details</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">
                        Full Name
                    </label>
                    <input wire:model="name" type="text" id="name" name="name" required
                        class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 focus:bg-white transition-all font-bold text-gray-900">
                    @error('name')
                        <p class="text-xs text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">
                        Email Address
                    </label>
                    <input wire:model="email" type="email" id="email" name="email" required
                        class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 focus:bg-white transition-all font-bold text-gray-900">
                    @error('email')
                        <p class="text-xs text-rose-600 font-bold mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if ($this->hasUnverifiedEmail)
                <div class="p-6 bg-amber-50 rounded-3xl border border-amber-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-amber-500 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-amber-900 font-bold">
                            Your email address is unverified.
                        </p>
                        <button type="button"
                            class="text-primary-600 hover:text-primary-700 text-xs font-black uppercase tracking-widest mt-1 transition"
                            wire:click.prevent="resendVerificationNotification">
                            Resend verification link
                        </button>
                    </div>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div
                        class="p-4 bg-success-50 rounded-2xl border border-success-100 text-success-700 text-[10px] font-black uppercase tracking-widest">
                        A new verification link has been sent to your email address.
                    </div>
                @endif
            @endif

            <div class="flex items-center gap-6 pt-6 border-t border-gray-50">
                <button type="submit"
                    class="px-12 py-5 bg-primary-600 text-white rounded-full font-black text-sm uppercase tracking-widest hover:bg-primary-700 hover:shadow-2xl hover:shadow-primary-600/20 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all active:scale-95 shadow-xl shadow-primary-600/10 min-w-[200px]">
                    {{ __('Save Changes') }}
                </button>

                <x-action-message
                    class="text-xs font-black text-success-600 uppercase tracking-widest flex items-center gap-2"
                    on="profile-updated">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Changes Saved!') }}
                </x-action-message>
            </div>
        </div>
    </form>

    <div class="mt-12">
        <livewire:settings.connected-accounts />
    </div>

    @if ($this->showDeleteUser)
        <div class="mt-12">
            <livewire:settings.delete-user-form />
        </div>
    @endif
</div>