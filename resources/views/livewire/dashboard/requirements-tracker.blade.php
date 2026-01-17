<div class="overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
        <div>
            <h3 class="font-black text-gray-900 font-display uppercase tracking-widest text-sm">Application Tracker</h3>
            <p class="text-[10px] text-gray-500 font-bold max-w-[200px] leading-tight mt-1">
                {{ $savedScholarship->scholarship->title }}
            </p>
        </div>
        <div class="text-right">
            <span class="text-3xl font-black text-primary-600 font-display">{{ $progress }}%</span>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em]">Progress</p>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="h-2 w-full bg-gray-100 relative">
        <div class="h-full bg-primary-600 transition-all duration-700 ease-out" style="width: {{ $progress }}%"></div>
    </div>

    <div class="p-6">
        @if($requirements->count() > 0)
            <div class="space-y-6">
                @foreach($requirements as $requirement)
                    <div class="space-y-3" wire:key="req-{{ $requirement['id'] }}">
                        <div class="flex items-start gap-4 group">
                            <div class="pt-1">
                                <button wire:click="toggleRequirement({{ $requirement['id'] }})" wire:loading.attr="disabled"
                                    class="w-7 h-7 rounded-full border-2 transition-all flex items-center justify-center
                                                                                                     {{ $requirement['completed']
                    ? 'bg-primary-600 border-primary-600 text-white shadow-lg shadow-primary-600/30'
                    : 'border-gray-200 text-transparent hover:border-primary-400' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-start justify-between">
                                    <h4
                                        class="text-sm font-bold transition-all {{ $requirement['completed'] ? 'text-gray-300 line-through' : 'text-gray-900' }}">
                                        {{ $requirement['title'] }}
                                    </h4>
                                    <button wire:click="editNote({{ $requirement['id'] }})"
                                        class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-full transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span
                                        class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full border
                                                                                                                                    {{ $requirement['is_required'] ? 'bg-warning-50 text-warning-700 border-warning-100' : 'bg-gray-100 text-gray-500 border-gray-200' }}">
                                        {{ $requirement['is_required'] ? 'Required' : 'Optional' }}
                                    </span>
                                    <span class="text-[10px] font-bold text-gray-400 capitalize">
                                        {{ $requirement['type']->label() }}
                                    </span>
                                    @if($requirement['notes'])
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span class="text-[10px] font-bold text-gray-400 italic truncate max-w-[150px]">
                                            {{ $requirement['notes'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Note Editing Area --}}
                        @if($editingRequirementId === $requirement['id'])
                            <div class="ml-11 bg-white rounded-2xl p-6 border border-gray-100 shadow-200/50" x-data
                                x-init="$refs.noteInput.focus()" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 -translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0">
                                <textarea wire:model="currentNote" x-ref="noteInput"
                                    class="w-full bg-gray-50 border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 p-4 min-h-[100px] transition-all"
                                    placeholder="Add a progress note..."></textarea>
                                <div class="flex justify-end gap-3 mt-4">
                                    <button wire:click="cancelEditNote"
                                        class="px-5 py-2 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 transition">Cancel</button>
                                    <button wire:click="saveNote"
                                        class="px-6 py-2 bg-primary-600 text-white text-xs font-black uppercase tracking-widest rounded-full hover:bg-primary-700 transition shadow-xl shadow-primary-600/10">Save</button>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div
                    class="w-16 h-16 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 mx-auto mb-4 border border-gray-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <p class="text-sm text-gray-400 font-bold uppercase tracking-widest leading-loose">No requirements<br>found
                </p>
            </div>
        @endif
    </div>
</div>