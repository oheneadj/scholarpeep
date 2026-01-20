<div x-data="{ open: false }" @status-update-loaded.window="open = true"
    @close-modal.window="if($event.detail.id === 'status-update-modal') open = false"
    @status-updated.window="open = false" x-show="open" class="fixed inset-0 overflow-hidden z-[70]"
    style="display: none;">

    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-md transition-opacity" @click="open = false"
            x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <div class="w-screen max-w-md transform transition-all duration-500" x-show="open"
                x-transition:enter="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="translate-x-0" x-transition:leave-end="translate-x-full">
                <div class="h-full flex flex-col bg-white shadow-2xl">
                    <div class="p-6 bg-white border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Manage Status</h2>
                        </div>
                        <button @click="open = false"
                            class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-8">
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Update Application Status</h3>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Keep track of
                                    your scholarship progress</p>
                            </div>

                            <form wire:submit.prevent="updateStatus" class="space-y-8">
                                <!-- Status Selection -->
                                <div class="grid grid-cols-1 gap-4">
                                    @foreach(\App\Enums\ApplicationStatus::cases() as $statusOption)
                                                                    <label class="relative flex cursor-pointer rounded-xl border p-4 transition-all duration-200
                                                                            {{ $status === $statusOption->value
                                        ? 'border-primary-600 ring-1 ring-primary-600 bg-primary-50/50'
                                        : 'border-gray-200 bg-white hover:border-gray-300' }}">
                                                                        <input type="radio" wire:model.live="status" value="{{ $statusOption->value }}"
                                                                            class="sr-only">
                                                                        <span class="flex flex-1">
                                                                            <span class="flex flex-col">
                                                                                <span
                                                                                    class="block text-sm font-bold uppercase tracking-wider
                                                                                        {{ $status === $statusOption->value ? 'text-primary-700' : 'text-gray-900' }}">
                                                                                    {{ $statusOption->label() }}
                                                                                </span>
                                                                                <span class="mt-1 text-xs text-gray-500 leading-normal">
                                                                                    {{ $this->getStatusDescription($statusOption->value) }}
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                                        @if($status === $statusOption->value)
                                                                            <svg class="h-5 w-5 text-primary-600 shrink-0" viewBox="0 0 20 20"
                                                                                fill="currentColor">
                                                                                <path fill-rule="evenodd"
                                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                                    clip-rule="evenodd" />
                                                                            </svg>
                                                                        @endif
                                                                    </label>
                                    @endforeach
                                </div>

                                <!-- Date Applied -->
                                <div x-show="$wire.status === 'applied' || $wire.status === 'pending'" x-cloak
                                    class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Date Applied /
                                        Planned</label>
                                    <input type="date" wire:model="appliedAt"
                                        class="w-full rounded-lg border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10 text-sm bg-gray-50">
                                </div>

                                <!-- Notes -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Internal Notes</label>
                                    <textarea wire:model="notes" rows="4"
                                        class="w-full rounded-lg border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10 text-sm placeholder-gray-400 bg-gray-50"
                                        placeholder="Add private notes..."></textarea>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-6">
                                    <button type="submit"
                                        class="w-full bg-primary-600 text-white rounded-full py-4 text-sm font-bold uppercase tracking-widest hover:bg-primary-700 transition-all shadow-md active:scale-[0.98]">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>