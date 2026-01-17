<x-layouts::auth>
    <div class="flex flex-col gap-8">
        <x-auth-header :title="__('Verify Email')" :description="__('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?')" />

        @if (session('status') == 'verification-link-sent')
            <div
                class="bg-success-50 border border-success-100 text-success-700 px-6 py-4 rounded-[2rem] flex items-start shadow-xl shadow-success-500/5">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-success-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-[10px] font-black uppercase tracking-widest leading-relaxed">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </p>
            </div>
        @endif

        <div class="flex flex-col gap-6">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full bg-primary-600 text-white px-8 py-4 rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/50 transition-all shadow-xl shadow-primary-600/10 active:scale-[0.98]">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit"
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-gray-600 transition underline decoration-gray-200 underline-offset-8"
                    data-test="logout-button">
                    {{ __('Sign out instead') }}
                </button>
            </form>
        </div>
    </div>
</x-layouts::auth>