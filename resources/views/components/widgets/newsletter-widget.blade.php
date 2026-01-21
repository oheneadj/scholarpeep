<div
    class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-900 to-primary-800 border border-primary-800 shadow-xl group">
    <!-- Decorative Elements -->
    <div
        class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-primary-500 rounded-full blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-700">
    </div>
    <div
        class="absolute bottom-0 left-0 -ml-8 -mb-8 w-32 h-32 bg-purple-500 rounded-full blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-700">
    </div>

    <!-- Noise Texture -->
    <div class="absolute inset-0 opacity-[0.03]"
        style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E')">
    </div>

    <div class="relative p-8 text-center">
        <!-- Icon -->
        <div
            class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10 shadow-lg mb-6 group-hover:-translate-y-1 transition-transform duration-300">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>

        <h3 class="text-xl font-black font-display text-white mb-2">Weekly Insights</h3>
        <p class="text-primary-100 text-sm leading-relaxed mb-6">
            Join <span class="font-bold text-white">10,000+</span> students getting scholarship alerts.
        </p>

        <form class="space-y-3 relative group/form">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-primary-300 group-focus-within/form:text-white transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input type="email" placeholder="Your email address"
                    class="block w-full pl-10 pr-4 py-3 bg-white/10 border border-white/10 rounded-xl text-sm text-white placeholder-primary-200 focus:outline-none focus:bg-white/20 focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all shadow-sm">
            </div>

            <x-turnstile action="newsletter" theme="dark" class="my-2" />

            <button type="submit"
                class="block w-full py-3 px-4 bg-white text-primary-900 font-bold rounded-xl text-sm hover:bg-primary-50 active:transform active:scale-95 transition-all shadow-lg">
                Subscribe Now
            </button>
        </form>

        <p class="mt-4 text-xs text-primary-200/60">
            No spam, unsubscribe anytime.
        </p>
    </div>
</div>