<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ uploadModalOpen: false }"
    @close-modal.window="uploadModalOpen = false"
    @notify.window="toast.show = true; toast.message = $event.detail.message; setTimeout(() => { toast.show = false }, 3000)">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-black font-display text-gray-900 mb-2 tracking-tight">Documents</h1>
            <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-[0.2em]">Manage your resumes, essays,
                and transcripts</p>
        </div>
        <button @click="uploadModalOpen = true"
            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white text-sm font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-900/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Upload Document
        </button>
    </div>

    <!-- Stats / Type Filter -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach(['' => 'All Files', 'resume' => 'Resumes', 'essay' => 'Essays', 'transcript' => 'Transcripts'] as $key => $label)
            <button wire:click="$set('filterType', '{{ $key }}')"
                class="bg-white p-4 rounded-2xl border transition-all duration-200 flex items-center justify-between group
                    {{ $filterType === $key ? 'border-primary-500 ring-2 ring-primary-500/20 shadow-lg shadow-primary-500/10' : 'border-gray-100 hover:border-gray-200 hover:shadow-md' }}">
                <span
                    class="text-sm font-bold {{ $filterType === $key ? 'text-primary-600' : 'text-gray-600' }}">{{ $label }}</span>
                @if($filterType === $key)
                    <div class="w-2 h-2 rounded-full bg-primary-500"></div>
                @endif
            </button>
        @endforeach
    </div>

    <!-- Documents Grid -->
    @if($documents->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($documents as $doc)
                <div
                    class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm relative group hover:border-primary-100 transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center
                                    {{ match ($doc->type) {
                    'resume' => 'bg-blue-50 text-blue-600',
                    'essay' => 'bg-emerald-50 text-emerald-600',
                    'transcript' => 'bg-amber-50 text-amber-600',
                    default => 'bg-gray-50 text-gray-600'
                } }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex items-center gap-1">
                            <button wire:click="download({{ $doc->id }})"
                                class="p-2 text-gray-400 hover:text-primary-600 rounded-xl hover:bg-gray-50 transition"
                                title="Download">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </button>
                            <button wire:confirm="Are you sure you want to delete this document?"
                                wire:click="delete({{ $doc->id }})"
                                class="p-2 text-gray-400 hover:text-rose-600 rounded-xl hover:bg-rose-50 transition"
                                title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-1 truncate">{{ $doc->title }}</h3>
                    <div class="flex items-center gap-3 text-xs text-gray-500 font-medium mb-4">
                        <span class="uppercase tracking-wide">{{ ucfirst($doc->type) }}</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span>{{ $doc->created_at->format('M d, Y') }}</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span>{{ number_format($doc->size / 1024, 1) }} KB</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-gray-50 rounded-[2.5rem] border border-gray-100 border-dashed p-12 text-center">
            <div
                class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-gray-300 mx-auto mb-4 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No documents yet</h3>
            <p class="text-sm text-gray-500 mb-6">Upload your resume, essays, or transcripts to get started.</p>
            <button @click="uploadModalOpen = true"
                class="px-6 py-2.5 bg-white border border-gray-200 text-gray-900 text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-50 transition">
                Upload First Document
            </button>
        </div>
    @endif

    <!-- Upload Modal -->
    <div x-show="uploadModalOpen" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm"
                @click="uploadModalOpen = false"></div>

            <div
                class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black font-display text-gray-900">Upload Document</h3>
                    <button @click="uploadModalOpen = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="save">
                    <div class="space-y-4">
                        <!-- File Upload -->
                        <div x-data="{ isDropping: false, progress: 0 }" x-on:livewire-upload-start="progress = 0"
                            x-on:livewire-upload-finish="progress = 100" x-on:livewire-upload-error="progress = 0"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                            <div class="relative group cursor-pointer">
                                <input type="file" wire:model="upload"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    @dragover="isDropping = true" @dragleave="isDropping = false"
                                    @drop="isDropping = false">

                                <div class="border-2 border-dashed rounded-2xl p-8 text-center transition-all duration-200"
                                    :class="isDropping ? 'border-primary-500 bg-primary-50' : 'border-gray-200 bg-gray-50 group-hover:bg-gray-100'">

                                    @if($upload)
                                        <div class="text-emerald-600 font-bold flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            File Selected: {{ $upload->getClientOriginalName() }}
                                        </div>
                                    @else
                                        <div class="text-gray-400 mb-2">
                                            <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-900">Click to upload or drag and drop</p>
                                        <p class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX, JPG, PNG (Max 10MB)</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div x-show="progress > 0 && progress < 100"
                                class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary-600 rounded-full transition-all duration-300"
                                    :style="`width: ${progress}%`"></div>
                            </div>
                            @error('upload') <span class="text-xs font-bold text-rose-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">Document
                                Title</label>
                            <input type="text" wire:model="title"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all placeholder-gray-400"
                                placeholder="e.g. Fall 2025 Resume">
                            @error('title') <span class="text-xs font-bold text-rose-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1.5">Document
                                Type</label>
                            <select wire:model="type"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all cursor-pointer">
                                <option value="resume">Resume/CV</option>
                                <option value="essay">Essay or Personal Statement</option>
                                <option value="transcript">Transcript</option>
                                <option value="other">Other Document</option>
                            </select>
                            @error('type') <span class="text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="uploadModalOpen = false"
                            class="px-6 py-2.5 bg-white border border-gray-200 text-gray-500 text-sm font-bold uppercase tracking-widest rounded-xl hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-primary-600 text-white text-sm font-bold uppercase tracking-widest rounded-xl hover:bg-primary-700 transition shadow-lg shadow-primary-600/20">
                            Save Document
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>