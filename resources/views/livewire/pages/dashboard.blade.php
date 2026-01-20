<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ 
        openTracker: false, 
        toast: { show: false, message: '' },
        confirmDelete: { show: false, id: null, title: '', isBulk: false }
     }" @open-tracker.window="openTracker = true"
    @notify.window="toast.show = true; toast.message = $event.detail.message; setTimeout(() => { toast.show = false }, 3000)">

    {{-- Notification Toast --}}
    <div x-show="toast.show" class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] pointer-events-none">
        <div class="bg-gray-900 shadow-xl rounded-full px-6 py-3 border border-gray-800 flex items-center gap-3">
            <div class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></div>
            <span class="text-xs font-bold text-white uppercase tracking-wider px-2" x-text="toast.message"></span>
        </div>
    </div>
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-gray-900 mb-1 tracking-tight">My Dashboard</h1>
        <p class="text-xs font-semibold text-gray-400 tracking-wider">Manage your scholarship applications and
            track progress</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-6 mb-12">
        {{-- Saved --}}
        <x-dashboard.stat-card label="Saved" :value="$stats['saved']" subtext="Total" color="primary">
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
            </x-slot:icon>
        </x-dashboard.stat-card>

        {{-- Applied --}}
        <x-dashboard.stat-card label="Applied" :value="$stats['applied']" subtext="Done" color="blue">
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-dashboard.stat-card>

        {{-- Pending --}}
        <x-dashboard.stat-card label="Pending" :value="$stats['pending']" subtext="Decision" color="orange">
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-dashboard.stat-card>

        {{-- Expiring --}}
        <x-dashboard.stat-card label="Expiring" :value="$stats['expiring_soon']" subtext="7 Days" color="rose">
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </x-slot:icon>
        </x-dashboard.stat-card>

        {{-- Potential Award --}}
        <x-dashboard.stat-card label="Potential" color="emerald">
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
            <div class="flex items-baseline gap-1">
                <span class="text-[10px] font-black text-gray-400 uppercase">$</span>
                <span
                    class="text-2xl font-black text-gray-900 tracking-tight">{{ number_format($stats['potential_award'] / 1000, 1) }}k</span>
            </div>
        </x-dashboard.stat-card>

        {{-- Applied Value --}}
        <x-dashboard.stat-card label="Applied Val." color="emerald-dark">
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </x-slot:icon>
            <div class="flex items-baseline gap-1">
                <span class="text-[10px] font-black text-gray-400 uppercase">$</span>
                <span
                    class="text-2xl font-black text-gray-900 tracking-tight">{{ number_format($stats['applied_award'] / 1000, 1) }}k</span>
            </div>
        </x-dashboard.stat-card>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        {{-- Left Column: Pipeline --}}
        <div class="lg:col-span-8 space-y-8">
            {{-- Recommendations Section --}}
            @if(!$hasPreferences)
                <div class="bg-gray-900 rounded-2xl p-10 text-white relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-primary-600 rounded-full blur-[80px] opacity-40 group-hover:opacity-60 transition-opacity duration-700">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-600 rounded-full blur-[60px] opacity-30">
                    </div>

                    <div
                        class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
                        <div class="max-w-lg">
                            <h3 class="text-2xl font-bold mb-3 tracking-tight">Personalize your pipeline</h3>
                            <p class="text-gray-300 font-medium text-lg leading-relaxed">Tell us your preferences and we'll
                                curate the top scholarships that match your profile perfectly.</p>
                        </div>
                        <a href="{{ route('preferences.edit') }}"
                            class="px-8 py-3 bg-white text-gray-900 font-bold uppercase tracking-wider rounded-full hover:bg-gray-50 hover:scale-105 transition-all shadow-lg shrink-0">
                            Set Preferences
                        </a>
                    </div>
                </div>
            @elseif($recommendedScholarships->count() > 0)
                <div
                    class="bg-gradient-to-br from-primary-900 to-primary-800 rounded-2xl p-8 text-white relative overflow-hidden shadow-xl">
                    <div class="flex items-center justify-between mb-6 relative z-10">
                        <div>
                            <h3 class="text-lg font-bold">Recommended for You</h3>
                            <p class="text-primary-200 text-xs font-medium">Based on your preferences</p>
                        </div>
                        <a href="{{ route('scholarships.index') }}"
                            class="text-xs font-bold text-white/50 hover:text-white transition">View All</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 relative z-10">
                        @foreach($recommendedScholarships as $scholarship)
                            <div
                                class="bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/10 hover:bg-white/20 transition group">
                                <div class="flex items-start justify-between mb-3">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-primary-900 font-bold text-sm">
                                        {{ substr($scholarship->provider_name, 0, 1) }}
                                    </div>
                                    <span
                                        class="text-[10px] font-bold bg-emerald-500/20 text-emerald-300 px-2 py-1 rounded-lg">High
                                        Match</span>
                                </div>
                                <h4 class="font-bold text-white text-sm line-clamp-1 mb-0.5">{{ $scholarship->title }}</h4>
                                <p class="text-[10px] text-primary-200 line-clamp-1 mb-4 uppercase tracking-wider">
                                    {{ $scholarship->provider_name }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-sm font-bold text-emerald-300">${{ number_format($scholarship->award_amount) }}</span>
                                    <a href="{{ route('scholarships.show', $scholarship->slug) }}"
                                        class="w-8 h-8 rounded-lg bg-white text-primary-900 flex items-center justify-center hover:scale-110 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Scholarship Pipeline Widget --}}
            <x-dashboard.scholarship-pipeline :savedScholarships="$savedScholarships" />

            {{-- Saved Searches Widget --}}
            <x-widgets.saved-searches :searches="$savedSearches" />

            {{-- Recent Activity Widget --}}
            {{-- <x-dashboard.recent-activity :recentActivity="$recentActivity" /> --}}
        </div>

        {{-- Right Column: Side Widgets --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Streak Widget --}}
            <x-widgets.streak-widget :streak="$streakData['current']" :nextMilestone="$streakData['next_milestone']"
                :daysLeft="$streakData['days_left']" />

            {{-- Points Widget --}}
            <x-widgets.points-widget :summary="$pointsSummary" />

            {{-- Badges Widget --}}
            <x-widgets.badges-widget :badges="$recentBadges" />

            {{-- Recommended Tools Widget --}}
            <x-widgets.recommended-tools :tools="$affiliateTools" />

            {{-- Recently Viewed Widget --}}
            <livewire:dashboard.recently-viewed-widget />

            {{-- Calendar --}}
            {{--
            <livewire:dashboard.calendar /> --}}
        </div>
    </div>

    {{-- Modals and Slide-overs --}}
    <livewire:dashboard.scholarship-status-update />




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
</div>
</div>