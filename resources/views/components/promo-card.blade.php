<div class="sticky top-8 group">
    <div class="relative overflow-hidden rounded-2xl bg-gray-900 border border-gray-800 shadow-2xl">

        <!-- Background Effects -->
        <div
            class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-primary-600/20 blur-3xl group-hover:bg-primary-600/30 transition-colors duration-500">
        </div>
        <div
            class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-purple-600/20 blur-3xl group-hover:bg-purple-600/30 transition-colors duration-500">
        </div>

        <!-- Noise Texture Overlay -->
        <div class="absolute inset-0 opacity-[0.03]"
            style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E')">
        </div>

        <div class="relative p-8 z-10 flex flex-col h-full">
            <!-- Badge -->
            <div class="flex items-center justify-between mb-6">
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/10 backdrop-blur-md text-[10px] font-bold uppercase tracking-widest text-primary-200 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-400 animate-pulse"></span>
                    Premium
                </span>
                <span class="text-white/40">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
            </div>

            <!-- Content -->
            <h3 class="text-2xl font-black font-display text-white mb-3">Unlock <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">Scholarship</span>
                Database</h3>

            <p class="text-gray-400 text-sm leading-relaxed mb-8 border-l-2 border-gray-700 pl-4">
                Access over <strong class="text-white">50,000+</strong> verified opportunities. Smart filtering by GPA,
                major, and deadline.
            </p>

            <!-- Action -->
            <a href="#"
                class="mt-auto group/btn relative w-full overflow-hidden rounded-xl bg-white p-4 text-center font-bold text-gray-900 transition-transform hover:-translate-y-0.5">
                <span class="relative z-10 flex items-center justify-center gap-2">
                    Start Free Trial
                    <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </span>
                <div
                    class="absolute inset-0 -z-10 bg-gradient-to-r from-primary-50 to-purple-50 opacity-0 transition-opacity group-hover/btn:opacity-100">
                </div>
            </a>

            <p class="mt-4 text-center text-[10px] font-medium text-gray-500 uppercase tracking-widest">No credit card
                required</p>
        </div>
    </div>
</div>