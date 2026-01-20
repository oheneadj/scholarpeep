<div class="bg-white rounded-[2.5rem] border border-gray-100 overflow-hidden shadow-200/50 flex flex-col h-full">
    {{-- Calendar Header --}}
    <div class="p-8 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
        <div>
            <h2 class="text-xl font-bold font-display text-gray-900">
                {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
            </h2>
            <p class="text-xs text-gray-500 font-medium tracking-tight">Track your upcoming scholarship deadlines</p>
        </div>

        <div class="flex items-center gap-2">
            <button wire:click="previousMonth"
                class="p-2.5 hover:bg-white hover:shadow-sm rounded-xl border border-transparent hover:border-gray-200 transition-all active:scale-95 text-gray-400 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button wire:click="nextMonth"
                class="p-2.5 hover:bg-white hover:shadow-sm rounded-xl border border-transparent hover:border-gray-200 transition-all active:scale-95 text-gray-400 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Calendar Grid --}}
    <div class="flex-1 p-6 relative">
        <div class="grid grid-cols-7 gap-1 mb-2">
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="text-center py-2">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ $day }}</span>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 gap-1 flex-1">
            @foreach($days as $dayData)
                <div @if(isset($dayData['day']) && count($dayData['deadlines']) > 0)
                wire:click="selectDate('{{ $dayData['date'] }}')" @endif
                    class="relative min-h-[90px] p-2 rounded-2xl border transition-all duration-300
                                    {{ isset($dayData['day']) ? 'bg-white border-gray-100 group/day' : 'bg-transparent border-transparent' }}
                                    {{ (isset($dayData['day']) && count($dayData['deadlines']) > 0) ? 'cursor-pointer hover:border-primary-100 hover:bg-primary-50/30' : '' }}
                                    {{ ($selectedDate === ($dayData['date'] ?? '')) ? 'ring-2 ring-primary-500 border-primary-500 bg-primary-50/50' : '' }}
                                    {{ (($dayData['isCurrentDate'] ?? false) && $selectedDate !== ($dayData['date'] ?? '')) ? 'bg-primary-50/20 border-primary-200' : '' }}">

                    @if(isset($dayData['day']))
                        <div class="flex justify-between items-start">
                            <span
                                class="text-sm font-bold {{ ($dayData['isCurrentDate'] ?? false) ? 'text-primary-600' : 'text-gray-900' }}">
                                {{ $dayData['day'] }}
                            </span>
                            @if(count($dayData['deadlines']) > 0)
                                <div class="w-1.5 h-1.5 rounded-full bg-primary-600"></div>
                            @endif
                        </div>

                        @if(count($dayData['deadlines']) > 0)
                            <div class="mt-2 space-y-1">
                                @foreach(collect($dayData['deadlines'])->take(2) as $deadline)
                                    <div class="px-2 py-0.5 rounded-md text-[8px] font-black uppercase truncate
                                                                                                        {{ $deadline['status'] === 'accepted' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                                                                                        {{ $deadline['status'] === 'rejected' ? 'bg-rose-100 text-rose-700' : '' }}
                                                                                                        {{ $deadline['status'] === 'applied' ? 'bg-blue-100 text-blue-700' : '' }}
                                                                                                        {{ $deadline['status'] === 'saved' ? 'bg-gray-100 text-gray-600' : '' }}
                                                                                                        {{ $deadline['status'] === 'pending' ? 'bg-warning-100 text-warning-700' : '' }}
                                                                                                    " title="{{ $deadline['title'] }}">
                                        {{ $deadline['title'] }}
                                    </div>
                                @endforeach
                                @if(count($dayData['deadlines']) > 2)
                                    <div class="text-[8px] font-bold text-gray-400 pl-1">
                                        +{{ count($dayData['deadlines']) - 2 }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Selected Date Deadlines Overlay/Panel --}}
        @if($selectedDate)
            <div class="mt-8 pt-8 border-t border-gray-100 animate-in fade-in slide-in-from-bottom-4 duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">
                                Deadlines for {{ \Carbon\Carbon::parse($selectedDate)->format('M j, Y') }}
                            </h3>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tight">
                                {{ count($selectedDateDeadlines) }} Scholarship(s)
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('selectedDate', null)"
                        class="text-[10px] font-black text-gray-400 hover:text-gray-900 uppercase tracking-widest transition-colors">
                        Clear
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($selectedDateDeadlines as $deadline)
                        <div
                            class="p-3 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-between group hover:border-primary-200 transition-all">
                            <div class="flex-1 min-w-0 mr-4">
                                <p class="text-sm font-bold text-gray-900 truncate leading-tight mb-0.5">
                                    {{ $deadline['title'] }}
                                </p>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest
                                                                {{ $deadline['status'] === 'accepted' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                                                {{ $deadline['status'] === 'rejected' ? 'bg-rose-100 text-rose-700' : '' }}
                                                                {{ $deadline['status'] === 'applied' ? 'bg-blue-100 text-blue-700' : '' }}
                                                                {{ $deadline['status'] === 'saved' ? 'bg-gray-100 text-gray-600' : '' }}
                                                                {{ $deadline['status'] === 'pending' ? 'bg-warning-100 text-warning-700' : '' }}
                                                            ">
                                        {{ $deadline['status'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <button wire:click="addToGoogleCalendar({{ $deadline['id'] }})"
                                    class="p-2 text-gray-400 hover:text-primary-600 hover:bg-white rounded-xl transition-all shadow-sm"
                                    title="Add to Google Calendar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <button wire:click="$parent.showTracker({{ $deadline['id'] }})"
                                    class="p-2 text-gray-400 hover:text-primary-600 hover:bg-white rounded-xl transition-all shadow-sm"
                                    title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>