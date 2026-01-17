<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <x-settings.layout :heading="__('Notification Settings')" :subheading="__('Configure when and how you want to be notified about scholarship updates.')">
        <form wire:submit="saveSettings" class="space-y-8">
            {{-- Email Alerts --}}
            <div class="bg-white rounded-[2.5rem] shadow-200/50 p-10 border border-gray-100">
                <div class="mb-10">
                    <h3 class="text-xl font-black text-gray-900 mb-2 tracking-tight">Email Notifications</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Choose what alerts you want to
                        receive</p>
                </div>

                <div class="space-y-6">
                    <label
                        class="flex items-center justify-between p-6 rounded-3xl bg-gray-50 border border-transparent hover:border-gray-100 transition-all cursor-pointer group has-[:checked]:bg-primary-50/10 has-[:checked]:border-primary-100">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-primary-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-gray-900">New Scholarship Matches</p>
                                <p class="text-xs text-gray-400 font-bold">Get alerted when a new scholarship matches
                                    your preferences</p>
                            </div>
                        </div>
                        <div
                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-gray-200 peer-checked:bg-primary-600">
                            <input type="checkbox" wire:model.live="notify_new_matches" class="peer hidden">
                            <span
                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-0 peer-checked:translate-x-5"></span>
                        </div>
                    </label>

                    <label
                        class="flex items-center justify-between p-6 rounded-3xl bg-gray-50 border border-transparent hover:border-gray-100 transition-all cursor-pointer group has-[:checked]:bg-primary-50/10 has-[:checked]:border-primary-100">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-warning-500 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-gray-900">Deadline Reminders</p>
                                <p class="text-xs text-gray-400 font-bold">Receive alerts before your saved scholarship
                                    deadlines</p>
                            </div>
                        </div>
                        <div
                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-gray-200 peer-checked:bg-primary-600">
                            <input type="checkbox" wire:model.live="notify_deadlines" class="peer hidden">
                            <span
                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-0 peer-checked:translate-x-5"></span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Frequency --}}
            <div class="bg-white rounded-[2.5rem] shadow-200/50 p-10 border border-gray-100">
                <div class="mb-10">
                    <h3 class="text-xl font-black text-gray-900 mb-2 tracking-tight">Digest Frequency</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">How often should we bundle your
                        notifications?</p>
                </div>

                <div class="bg-gray-50 p-2 rounded-full inline-flex gap-2">
                    @foreach($frequencies as $freq)
                        <label class="relative cursor-pointer group">
                            <input type="radio" wire:model.live="notification_frequency" value="{{ $freq->value }}"
                                class="peer hidden">
                            <div
                                class="px-8 py-3 text-xs font-black uppercase tracking-widest rounded-full transition-all text-gray-500 hover:text-gray-900 peer-checked:bg-white peer-checked:text-primary-700 peer-checked:shadow-lg">
                                {{ $freq->label() }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Deadline Days --}}
            <div class="bg-white rounded-[2.5rem] shadow-200/50 p-10 border border-gray-100">
                <div class="mb-10">
                    <h3 class="text-xl font-black text-gray-900 mb-2 tracking-tight">Reminder Window</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Remind me <span
                            class="text-primary-600 font-black italic">{{ $deadline_reminder_days }} days</span> before
                        a deadline</p>
                </div>

                <div class="px-4">
                    <input type="range" wire:model.live="deadline_reminder_days" min="1" max="30"
                        class="w-full h-2 bg-gray-100 rounded-full appearance-none cursor-pointer accent-primary-600">
                    <div
                        class="flex justify-between mt-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                        <span>1 Day</span>
                        <span>15 Days</span>
                        <span>30 Days</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6 pt-4">
                <button type="submit"
                    class="px-12 py-5 bg-primary-600 text-white rounded-full font-black text-sm uppercase tracking-widest hover:bg-primary-700 transition-all active:scale-95 shadow-xl shadow-primary-600/10">
                    {{ __('Save Settings') }}
                </button>
            </div>
        </form>
    </x-settings.layout>
</div>