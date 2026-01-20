<div class="bg-white rounded-3xl shadow-200/50 p-8 border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-black text-gray-900 mb-1 tracking-tight">Connected Accounts</h3>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Manage your third-party integrations.
            </p>
        </div>
    </div>

    <div class="space-y-4">
        {{-- Google Calendar --}}
        <div class="flex items-center justify-between p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center p-2.5">
                    <svg viewBox="0 0 24 24" class="w-full h-full">
                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4" />
                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853" />
                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                            fill="#FBBC05" />
                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                            fill="#EA4335" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Google Calendar</h4>
                    <p class="text-xs font-medium text-gray-500">Sync scholarship deadlines to your calendar.</p>
                </div>
            </div>

            @if(!empty($user->google_calendar_token))
                <div class="flex items-center gap-4">
                    <span
                        class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Connected
                    </span>
                    <button wire:click="disconnectGoogle"
                        wire:confirm="Are you sure you want to disconnect Google Calendar?"
                        class="text-xs font-bold text-gray-400 hover:text-red-500 transition-colors">
                        Disconnect
                    </button>
                </div>
            @else
                <a href="{{ route('google.login') }}"
                    class="px-6 py-3 bg-white border-2 border-gray-100 hover:border-primary-100 text-gray-700 hover:text-primary-700 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                    Connect
                </a>
            @endif
        </div>
    </div>
</div>