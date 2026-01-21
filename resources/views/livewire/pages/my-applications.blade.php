<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ 
    openTracker: false, 
    toast: { show: false, message: '' },
    confirmDelete: { show: false, id: null, title: '', isBulk: false }
 }" @open-tracker.window="openTracker = true"
    @notify.window="toast.show = true; toast.message = $event.detail.message; setTimeout(() => { toast.show = false }, 3000)">

    {{-- Notification Toast --}}
    <div x-show="toast.show" class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] pointer-events-none"
        style="display: none;">
        <div class="bg-gray-900 shadow-200/50 rounded-full px-6 py-3 border border-gray-800 flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></div>
            <span class="text-sm font-bold text-white uppercase tracking-widest px-2" x-text="toast.message"></span>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
        <div>
            <h1 class="text-4xl font-black font-display text-gray-900 mb-2 tracking-tight">My Applications</h1>
            <p class="text-gray-500 font-medium">Manage and track your entire scholarship pipeline in one place.</p>
        </div>
        <a href="{{ route('scholarships.index') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white rounded-2xl font-bold hover:bg-primary-700 transition shadow-lg shadow-primary-600/20 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Find More Scholarships
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-12">
        @foreach(\App\Enums\ApplicationStatus::cases() as $status)
            <div wire:click="$set('statusFilter', '{{ $status->value }}')" class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm cursor-pointer hover:border-primary-200 hover:shadow-md transition-all group
                                 {{ $statusFilter === $status->value ? 'ring-2 ring-primary-500 ring-offset-2' : '' }}">
                <div class="flex items-center justify-between mb-2">
                    <span
                        class="text-xs font-bold uppercase tracking-wider text-gray-400 group-hover:text-primary-600 transition-colors">{{ $status->label() }}</span>
                    <div class="w-2 h-2 rounded-full
                                        {{ $status->value === 'accepted' ? 'bg-emerald-500' : '' }}
                                        {{ $status->value === 'rejected' ? 'bg-rose-500' : '' }}
                                        {{ $status->value === 'applied' ? 'bg-blue-500' : '' }}
                                        {{ $status->value === 'saved' ? 'bg-gray-400' : '' }}
                                        {{ $status->value === 'pending' ? 'bg-amber-500' : '' }}"></div>
                </div>
                <div class="text-3xl font-black text-gray-900">
                    {{ $statusCounts[$status->value] ?? 0 }}
                </div>
            </div>
        @endforeach
    </div>

    <div
        class="bg-white rounded-[2.5rem] border border-gray-100 overflow-hidden shadow-200/50 relative min-h-[600px] flex flex-col">
        {{-- Bulk Actions Bar --}}
        <div x-show="$wire.selectedSavedIds.length > 0" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-full opacity-0"
            class="fixed bottom-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-6 py-4 rounded-3xl shadow-2xl z-50 flex items-center gap-6 border border-gray-800 backdrop-blur-md bg-opacity-95">
            <div class="flex items-center gap-3 border-r border-gray-700 pr-6">
                <span
                    class="bg-primary-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-black">
                    {{ count($selectedSavedIds) }}
                </span>
                <span class="text-sm font-bold text-gray-300">items selected</span>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mr-2">Update Status:</span>
                @foreach(\App\Enums\ApplicationStatus::cases() as $status)
                    <button wire:click="bulkUpdateStatus('{{ $status->value }}')"
                        class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider transition-all hover:scale-105 active:scale-95
                                                       {{ $status->value === 'accepted' ? 'bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20' : '' }}
                                                       {{ $status->value === 'applied' ? 'bg-blue-500/10 text-blue-400 hover:bg-blue-500/20' : '' }}
                                                       {{ $status->value === 'pending' ? 'bg-warning-500/10 text-warning-400 hover:bg-warning-500/20' : '' }}
                                                       {{ $status->value === 'rejected' ? 'bg-rose-500/10 text-rose-400 hover:bg-rose-500/20' : '' }}
                                                       {{ $status->value === 'saved' ? 'bg-gray-500/10 text-gray-400 hover:bg-gray-500/20' : '' }}">
                        {{ $status->label() }}
                    </button>
                @endforeach
            </div>

            <div class="border-l border-gray-700 pl-6">
                <button @click="confirmDelete = { show: true, id: null, title: 'Selected Scholarships', isBulk: true }"
                    class="p-2 text-rose-400 hover:text-rose-300 hover:bg-rose-50/10 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 2 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Filters & Toolbar --}}
        <div
            class="p-8 border-b border-gray-100 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 bg-gray-50/30">
            <div class="flex flex-wrap items-center gap-4 w-full">
                {{-- Search --}}
                <div class="relative flex-1 min-w-[250px]">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Search scholarships or providers..."
                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                </div>

                {{-- Filters --}}
                <div class="flex flex-wrap items-center gap-3">
                    <select wire:model.live="statusFilter"
                        class="text-sm font-bold text-gray-700 border-gray-200 bg-white rounded-2xl px-4 py-2.5 focus:ring-primary-500 focus:border-primary-500 cursor-pointer min-w-[140px]">
                        <option value="">All Statuses</option>
                        @foreach(\App\Enums\ApplicationStatus::cases() as $status)
                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="deadlineFilter"
                        class="text-sm font-bold text-gray-700 border-gray-200 bg-white rounded-2xl px-4 py-2.5 focus:ring-primary-500 focus:border-primary-500 cursor-pointer min-w-[140px]">
                        <option value="">All Deadlines</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="past">Past</option>
                        <option value="rolling">Rolling</option>
                    </select>

                    @if($search || $statusFilter || $deadlineFilter)
                        <button wire:click="$set('search', ''); $set('statusFilter', ''); $set('deadlineFilter', '')"
                            class="text-xs font-bold text-rose-500 hover:text-rose-600 transition px-2">
                            Clear all
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="flex-1 overflow-x-auto">
            @if($savedScholarships->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <th class="px-6 py-4 w-10">
                                    <input type="checkbox" wire:model.live="selectAll"
                                        class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 transition cursor-pointer">
                                </th>
                                <th class="px-6 py-4 cursor-pointer hover:text-primary-600 transition group"
                                    wire:click="sortBy('title')">
                                    Scholarship
                                </th>
                                <th class="px-6 py-4 cursor-pointer hover:text-primary-600 transition group"
                                    wire:click="sortBy('deadline')">
                                    Deadline
                                </th>
                                <th class="px-6 py-4 cursor-pointer hover:text-primary-600 transition group"
                                    wire:click="sortBy('award_amount')">
                                    Award
                                </th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($savedScholarships as $saved)
                                <tr class="group hover:bg-gray-50/50 transition-colors duration-150">
                                    {{-- Checkbox --}}
                                    <td class="px-6 py-4">
                                        <input type="checkbox" wire:model.live="selectedSavedIds" value="{{ $saved->id }}"
                                            class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 transition cursor-pointer">
                                    </td>

                                    {{-- Scholarship Info --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 bg-white rounded-lg flex items-center justify-center p-1.5 shrink-0 border border-gray-100 overflow-hidden shadow-sm">
                                                @if($saved->scholarship->provider_logo)
                                                    <img src="{{ $saved->scholarship->provider_logo_url }}"
                                                        alt="{{ $saved->scholarship->provider_name }}"
                                                        class="max-h-full max-w-full object-contain" loading="lazy">
                                                @else
                                                    <div class="text-gray-400 font-black text-sm">
                                                        {{ substr($saved->scholarship->provider_name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('scholarships.show', $saved->scholarship->slug) }}"
                                                    class="font-bold text-gray-900 hover:text-primary-600 transition block mb-0.5 text-sm line-clamp-1">{{ $saved->scholarship->title }}</a>
                                                <p class="text-xs text-gray-400 font-medium">
                                                    {{ $saved->scholarship->provider_name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Deadline --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            @if($saved->scholarship->primary_deadline)
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-bold text-gray-900">{{ $saved->scholarship->primary_deadline->format('M j, Y') }}</span>
                                                    <span
                                                        class="text-[10px] font-bold uppercase tracking-wider 
                                                                                                                            {{ $saved->scholarship->primary_deadline->isPast() ? 'text-rose-500' : 'text-emerald-500' }}">
                                                        {{ $saved->scholarship->primary_deadline->diffForHumans() }}
                                                    </span>
                                                </div>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-600">
                                                    Rolling
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Award --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="font-mono font-bold text-gray-700 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100 text-xs">
                                            ${{ number_format($saved->scholarship->award_amount) }}
                                        </span>
                                    </td>

                                    {{-- Status & Progress --}}
                                    <td class="px-6 py-4 min-w-[200px]">
                                        <button wire:click="$dispatch('open-status-update', { id: {{ $saved->id }} })"
                                            class="w-full group/status text-left">
                                            <div class="flex items-center justify-between mb-2">
                                                <span
                                                    class="text-xs font-bold uppercase tracking-wider text-gray-600">{{ $saved->status->label() }}</span>
                                                <span
                                                    class="text-[10px] font-bold text-gray-400 group-hover/status:text-primary-600 transition-colors">Update</span>
                                            </div>

                                            <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden relative">
                                                {{-- Background steps --}}
                                                <div class="absolute inset-0 flex">
                                                    <div class="flex-1 border-r border-white/50 h-full"></div>
                                                    <div class="flex-1 border-r border-white/50 h-full"></div>
                                                    <div class="flex-1 border-r border-white/50 h-full"></div>
                                                </div>

                                                <div class="h-full rounded-full transition-all duration-500 relative
                                                                            {{ $saved->status->value === 'accepted' ? 'bg-emerald-500 w-full' : '' }}
                                                                            {{ $saved->status->value === 'rejected' ? 'bg-rose-500 w-full opacity-50' : '' }}
                                                                            {{ $saved->status->value === 'applied' ? 'bg-blue-500 w-3/4' : '' }}
                                                                            {{ $saved->status->value === 'pending' ? 'bg-amber-500 w-1/2' : '' }}
                                                                            {{ $saved->status->value === 'saved' ? 'bg-gray-300 w-1/4' : '' }}
                                                                        "></div>
                                            </div>
                                        </button>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1">
                                            {{-- Manage Status --}}
                                            <x-scholarship.manage-status-button :id="$saved->id" />

                                            {{-- Track Requirements --}}
                                            <button wire:click="showTracker({{ $saved->id }})"
                                                class="p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition"
                                                title="Track Requirements">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </button>

                                            {{-- View Details --}}
                                            <a href="{{ route('scholarships.show', $saved->scholarship->slug) }}"
                                                class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition"
                                                title="View Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            {{-- Delete --}}
                                            <button
                                                @click="confirmDelete = { show: true, id: {{ $saved->id }}, title: '{{ addslashes($saved->scholarship->title) }}', isBulk: false }"
                                                class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                                title="Remove">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 2 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-[2rem] flex items-center justify-center text-gray-300 mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold font-display text-gray-900 mb-2">No applications found</h3>
                    <p class="text-gray-500 max-w-sm mx-auto mb-8">
                        @if($search || $statusFilter || $deadlineFilter)
                            Try adjusting your filters to find what you're looking for.
                        @else
                            You haven't saved any scholarships yet. Start exploring to build your pipeline!
                        @endif
                    </p>
                    @if($search || $statusFilter || $deadlineFilter)
                        <button wire:click="$set('search', ''); $set('statusFilter', ''); $set('deadlineFilter', '')"
                            class="inline-flex items-center px-8 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition">
                            Clear all filters
                        </button>
                    @else
                        <a href="{{ route('scholarships.index') }}"
                            class="inline-flex items-center px-10 py-4 bg-primary-600 text-white font-black uppercase tracking-widest text-sm rounded-full hover:bg-primary-700 transition shadow-xl shadow-primary-600/10">
                            Explore Scholarships
                        </a>
                    @endif
                </div>
            @endif
        </div>

        @if($savedScholarships->hasPages())
            <div class="p-8 border-t border-gray-100 bg-gray-50/50">
                {{ $savedScholarships->links() }}
            </div>
        @endif

        <!-- Requirements Tracker Slide-over -->
        <div x-show="openTracker" class="fixed inset-0 overflow-hidden z-[65]" style="display: none;"
            x-transition:enter="transition ease-in-out duration-500" x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-500"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"
                    @click="openTracker = false" x-show="openTracker" x-transition:enter="ease-in duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-out duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"></div>

                <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                    <div class="w-screen max-w-md">
                        <div class="h-full flex flex-col bg-gray-50 shadow-2xl">
                            <div class="p-6 bg-white border-b border-gray-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-bold text-gray-900 font-display">Requirements Tracker</h2>
                                </div>
                                <button @click="openTracker = false"
                                    class="p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-100 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex-1 overflow-y-auto p-6">
                                @if($selectedSavedId)
                                    <livewire:dashboard.requirements-tracker :key="$selectedSavedId"
                                        :saved-scholarship-id="$selectedSavedId" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="confirmDelete.show" class="fixed inset-0 z-[200] overflow-y-auto" style="display: none;"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
                @click="confirmDelete.show = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative inline-block align-middle bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 z-[210]"
                x-show="confirmDelete.show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="bg-white px-8 pt-10 pb-8">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-rose-50 sm:mx-0 sm:h-14 sm:w-14">
                            <svg class="h-8 w-8 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-6 sm:text-left">
                            <h3 class="text-2xl font-black font-display text-gray-900 leading-tight mb-2">
                                Remove scholarship?
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 font-medium">
                                    Are you sure you want to remove <span class="font-bold text-gray-900"
                                        x-text="confirmDelete.title"></span>? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-8 py-6 sm:flex sm:flex-row-reverse gap-3">
                    <button type="button"
                        class="w-full inline-flex justify-center px-8 py-3.5 bg-rose-600 text-white text-sm font-black uppercase tracking-widest rounded-2xl hover:bg-rose-700 transition shadow-lg shadow-rose-600/20 active:scale-95 sm:w-auto"
                        @click="confirmDelete.isBulk ? $wire.bulkDelete() : $wire.deleteSaved(parseInt(confirmDelete.id)); confirmDelete.show = false">
                        Confirm Delete
                    </button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center px-8 py-3.5 bg-white border border-gray-200 text-gray-500 text-sm font-black uppercase tracking-widest rounded-2xl hover:bg-gray-50 transition sm:mt-0 sm:w-auto active:scale-95"
                        @click="confirmDelete.show = false">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <livewire:dashboard.scholarship-status-update />
</div>