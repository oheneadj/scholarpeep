@props(['savedScholarships', 'search' => '', 'statusFilter' => ''])

{{-- Main Pipeline Widget --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-200/50 relative flex flex-col group/pipeline">
    {{-- Header --}}
    <div class="p-6 border-b border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 relative z-10 bg-white/50 backdrop-blur-md">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Active Pipeline</h2>
            </div>
            <p class="text-xs font-medium text-gray-500">Manage your scholarship applications</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
            <div class="relative flex-1 lg:w-64 w-full group/search">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within/search:text-primary-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search..."
                    class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-100 rounded-lg text-sm font-medium text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all placeholder-gray-400">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select wire:model.live="statusFilter"
                    class="text-xs font-semibold text-gray-700 border-gray-100 bg-gray-50 rounded-lg px-4 py-2 pr-8 focus:ring-2 focus:ring-primary-500 focus:border-transparent cursor-pointer shadow-sm hover:border-gray-200 transition-all uppercase tracking-wider w-full sm:w-auto">
                    <option value="">All Statuses</option>
                    @foreach(\App\Enums\ApplicationStatus::cases() as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="p-6 relative z-10 flex-1">
        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-10">
            @foreach(\App\Enums\ApplicationStatus::cases() as $status)
                @php
                    $count = auth()->user()->savedScholarships()->where('status', $status)->count();
                    $style = match ($status->value) {
                        'saved' => [
                            'bg' => 'bg-gray-50',
                            'text' => 'text-gray-900',
                            'count' => 'text-gray-900'
                        ],
                        'applied' => [
                            'bg' => 'bg-blue-50',
                            'text' => 'text-blue-600',
                            'count' => 'text-blue-700'
                        ],
                        'accepted' => [
                            'bg' => 'bg-emerald-50',
                            'text' => 'text-emerald-600',
                            'count' => 'text-emerald-700'
                        ],
                        'rejected' => [
                            'bg' => 'bg-rose-50',
                            'text' => 'text-rose-600',
                            'count' => 'text-rose-700'
                        ],
                        'pending' => [
                            'bg' => 'bg-amber-50',
                            'text' => 'text-amber-600',
                            'count' => 'text-amber-700'
                        ],
                        default => [
                            'bg' => 'bg-gray-50',
                            'text' => 'text-gray-600',
                            'count' => 'text-gray-700'
                        ]
                    };
                @endphp
                <a href="{{ route('my-applications', ['statusFilter' => $status->value]) }}"
                    class="group flex flex-col p-5 rounded-2xl transition-all hover:scale-105 duration-300 {{ $style['bg'] }} {{ $style['text'] }} hover:shadow-md">
                    <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 mb-2">{{ $status->label() }}</span>
                    <span class="text-2xl font-bold tracking-tight {{ $style['count'] }}">{{ $count }}</span>
                </a>
            @endforeach
        </div>

        {{-- Upcoming Deadlines --}}
        <div>
            <div class="flex items-center justify-between mb-6 px-1">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">Critical Deadlines</h3>
                </div>
                <a href="{{ route('my-applications', ['sortField' => 'deadline', 'sortDirection' => 'asc']) }}"
                    class="text-xs font-bold text-primary-600 hover:text-primary-700 transition-colors">
                    View Full Pipeline
                </a>
            </div>

            @if($savedScholarships->count() > 0)
                <div class="space-y-4">
                    @foreach($savedScholarships->sortBy('scholarship.primary_deadline')->take(5) as $saved)
                        <div class="group relative flex items-center gap-5 p-4 rounded-2xl border border-gray-100 bg-white hover:border-primary-200 hover:shadow-md transition-all duration-300">
                            {{-- Date Box --}}
                            <div class="shrink-0 w-16 h-16 rounded-xl border border-gray-50 bg-gray-50/50 flex flex-col items-center justify-center text-center group-hover:bg-white group-hover:shadow-sm transition-all duration-300">
                                @if($saved->scholarship->primary_deadline)
                                    <span class="text-[10px] font-bold text-rose-500 uppercase tracking-widest mb-0.5">{{ $saved->scholarship->primary_deadline->format('M') }}</span>
                                    <span class="text-2xl font-bold text-gray-900 leading-none tracking-tight">{{ $saved->scholarship->primary_deadline->format('d') }}</span>
                                @else
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">ROLLING</span>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider truncate">
                                        {{ $saved->scholarship->provider_name }}
                                    </span>
                                    @if($saved->scholarship->primary_deadline && $saved->scholarship->primary_deadline->isFuture() && $saved->scholarship->primary_deadline->diffInDays() < 7)
                                        <span class="text-[10px] font-bold text-rose-500 uppercase tracking-wider flex items-center gap-1">
                                            <span class="w-1 h-1 rounded-full bg-rose-500 animate-pulse"></span>
                                            Urgent
                                        </span>
                                    @endif
                                </div>
                                <h4 class="text-base font-bold text-gray-900 truncate group-hover:text-primary-600 transition-colors tracking-tight">
                                    {{ $saved->scholarship->title }}
                                </h4>

                                <div class="mt-2 flex items-center">
                                    <button wire:click="$dispatch('open-status-update', { id: {{ $saved->id }} })"
                                        class="flex items-center gap-2 px-2.5 py-1 rounded-lg border border-gray-100 bg-white shadow-sm transition-all hover:bg-gray-50 group/status">
                                        <div class="w-2 h-2 rounded-full {{ match($saved->status->value) {
                                            'accepted' => 'bg-emerald-500',
                                            'rejected' => 'bg-rose-500',
                                            'applied' => 'bg-blue-500',
                                            'pending' => 'bg-amber-500',
                                            default => 'bg-gray-400'
                                        } }}"></div>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-600">
                                            {{ $saved->status->label() }}
                                        </span>
                                        <svg class="w-3 h-3 text-gray-400 group-hover/status:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2">
                                <a href="{{ route('scholarships.show', $saved->scholarship->slug) }}"
                                    class="p-3 rounded-xl bg-gray-50 text-gray-400 hover:bg-primary-600 hover:text-white transition-all duration-300"
                                    title="View Scholarship">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('my-applications') }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-700 transition-colors">
                        Manage Full Pipeline
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            @else
                <div class="py-16 text-center border-2 border-dashed border-gray-100 rounded-2xl bg-gray-50/30">
                    <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center text-gray-200 mx-auto mb-4 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Your pipeline is empty</h3>
                    <p class="text-sm text-gray-500 mb-6">Start saving scholarships to track them here.</p>
                    <a href="{{ route('scholarships.index') }}"
                        class="inline-flex px-6 py-2.5 bg-primary-600 text-white text-sm font-semibold rounded-full hover:bg-primary-700 transition-colors shadow-sm">
                        Browse Scholarships
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>