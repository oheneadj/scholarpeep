<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ openTracker: false, toast: { show: false, message: '' } }" 
     @open-tracker.window="openTracker = true"
     @notify.window="toast.show = true; toast.message = $event.detail.message; setTimeout(() => { toast.show = false }, 3000)">

    {{-- Notification Toast --}}
    <div x-show="toast.show" 
         class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] pointer-events-none">
        <div class="bg-gray-900 shadow-200/50 rounded-full px-6 py-3 border border-gray-800 flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></div>
            <span class="text-sm font-bold text-white uppercase tracking-widest px-2" x-text="toast.message"></span>
        </div>
    </div>
    <div class="mb-12">
        <h1 class="text-4xl font-black font-display text-gray-900 mb-2 tracking-tight">My Dashboard</h1>
        <p class="text-[10px] text-gray-400 font-extrabold uppercase tracking-[0.2em]">Manage your scholarship applications and track progress</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-200/50">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Saved</p>
            <p class="text-3xl font-bold text-gray-900 font-display">{{ $stats['saved'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-200/50">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Applied</p>
            <p class="text-3xl font-bold text-primary-600 font-display">{{ $stats['applied'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-200/50">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Pending</p>
            <p class="text-3xl font-bold text-warning-500 font-display">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-200/50">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Accepted</p>
            <p class="text-3xl font-bold text-emerald-500 font-display">{{ $stats['accepted'] }}</p>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-[2.5rem] border border-gray-100 overflow-hidden shadow-200/50 relative">
        {{-- Bulk Actions Bar --}}
        <div x-show="$wire.selectedSavedIds.length > 0" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-full opacity-0"
             class="fixed bottom-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-6 py-4 rounded-3xl shadow-2xl z-50 flex items-center gap-6 border border-gray-800 backdrop-blur-md bg-opacity-95">
            <div class="flex items-center gap-3 border-r border-gray-700 pr-6">
                <span class="bg-primary-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-black">
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
                <button wire:click="bulkDelete" 
                        wire:confirm="Are you sure you want to remove these scholarship applications?"
                        class="p-2 text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-gray-50/30">
            <div>
                <h2 class="text-xl font-bold font-display text-gray-900">Scholarship Pipeline</h2>
                <p class="text-xs text-gray-500 font-medium">Track and manage your applications efficiently.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-4 w-full md:w-auto">
                {{-- Search --}}
                <div class="relative flex-1 md:w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search scholarships..." 
                           class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                </div>

                {{-- Status Filter --}}
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Filter:</span>
                    <select wire:model.live="statusFilter"
                            class="text-sm font-bold text-gray-900 border-gray-200 bg-white rounded-2xl px-4 py-2 focus:ring-primary-500 focus:border-primary-500 cursor-pointer">
                        <option value="">All Statuses</option>
                        @foreach(\App\Enums\ApplicationStatus::cases() as $status)
                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        @if($savedScholarships->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <th class="px-8 py-4 w-10">
                                <input type="checkbox" wire:model.live="selectAll" 
                                       class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 transition cursor-pointer">
                            </th>
                            <th class="px-4 py-4 cursor-pointer hover:text-primary-600 transition" wire:click="sortBy('title')">
                                <div class="flex items-center gap-1">
                                    Scholarship
                                    @if($sortField === 'title')
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-8 py-4 cursor-pointer hover:text-primary-600 transition" wire:click="sortBy('deadline')">
                                <div class="flex items-center gap-1">
                                    Deadline
                                    @if($sortField === 'deadline')
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($savedScholarships as $saved)
                            <tr class="group hover:bg-gray-50/50 transition {{ in_array((string)$saved->id, $selectedSavedIds) ? 'bg-primary-50/30' : '' }}">
                                <td class="px-8 py-6">
                                    <input type="checkbox" wire:model.live="selectedSavedIds" value="{{ $saved->id }}"
                                           class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 transition cursor-pointer">
                                </td>
                                <td class="px-4 py-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center p-2 shrink-0">
                                            @if($saved->scholarship->provider_logo)
                                                <img src="{{ Str::startsWith($saved->scholarship->provider_logo, 'http') ? $saved->scholarship->provider_logo : \Illuminate\Support\Facades\Storage::url($saved->scholarship->provider_logo) }}"
                                                    alt="{{ $saved->scholarship->provider_name }}"
                                                    class="max-h-full max-w-full object-contain">
                                            @else
                                                <div class="text-primary-600 font-bold text-sm">
                                                    {{ substr($saved->scholarship->provider_name, 0, 1) }}</div>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('scholarships.show', $saved->scholarship->slug) }}"
                                                class="font-bold text-gray-900 hover:text-primary-600 transition block mb-0.5">{{ $saved->scholarship->title }}</a>
                                            <p class="text-xs text-gray-500">{{ $saved->scholarship->provider_name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-gray-900">
                                        {{ $saved->scholarship->primary_deadline?->format('M j, Y') ?? 'Rolling' }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">
                                        {{ $saved->scholarship->primary_deadline?->diffForHumans() ?? '' }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <select wire:change="updateStatus({{ $saved->id }}, $event.target.value)" class="text-xs font-bold border rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-primary-500
                                                {{ $saved->status->value === 'accepted' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                                {{ $saved->status->value === 'rejected' ? 'bg-rose-50 text-rose-700 border-rose-200' : '' }}
                                                {{ $saved->status->value === 'applied' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                                {{ $saved->status->value === 'saved' ? 'bg-gray-100 text-gray-600 border-gray-200' : '' }}
                                                {{ $saved->status->value === 'pending' ? 'bg-warning-50 text-warning-700 border-warning-200' : '' }}
                                            ">
                                        @foreach(\App\Enums\ApplicationStatus::cases() as $status)
                                            <option value="{{ $status->value }}" {{ $saved->status === $status ? 'selected' : '' }}>
                                                {{ $status->label() }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <button wire:click="showTracker({{ $saved->id }})"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition shadow-sm active:scale-95"
                                            title="Track Requirements">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            Track
                                        </button>
                                        <a href="{{ $saved->scholarship->application_url }}" target="_blank"
                                            class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition"
                                            title="Apply Now">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                        <button wire:click="deleteSaved({{ $saved->id }})"
                                            wire:confirm="Are you sure you want to remove this scholarship?"
                                            class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                            title="Remove">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-8 border-t border-gray-100">
                {{ $savedScholarships->links() }}
            </div>
        @else
            <div class="p-20 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold font-display text-gray-900 mb-2">No scholarships saved yet</h3>
                <p class="text-gray-500 mb-8">Start exploring scholarships and save your favorites to track them here.</p>
                <a href="{{ route('scholarships.index') }}"
                    class="inline-flex items-center px-10 py-4 bg-primary-600 text-white font-black uppercase tracking-widest text-sm rounded-full hover:bg-primary-700 transition shadow-xl shadow-primary-600/10">
                    Explore Scholarships
                </a>
            </div>
        @endif
    </div>

    <!-- Slide-over -->
    <div x-show="openTracker" 
        class="fixed inset-0 overflow-hidden z-[60]" 
        style="display: none;"
        x-transition:enter="transition ease-in-out duration-500 sm:duration-700"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-500 sm:duration-700"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full">
        
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                @click="openTracker = false"
                x-show="openTracker"
                x-transition:enter="ease-in-out duration-500"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"></div>

            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div class="w-screen max-w-md">
                    <div class="h-full flex flex-col bg-gray-50 shadow-2xl">
                        <div class="p-6 bg-white border-b border-gray-100 flex items-center justify-between">
                            <h2 class="text-lg font-bold text-gray-900 font-display">Requirements Tracker</h2>
                            <button @click="openTracker = false" class="p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-100 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto p-6">
                            @if($selectedSavedId)
                                <livewire:dashboard.requirements-tracker :key="$selectedSavedId" :saved-scholarship-id="$selectedSavedId" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>