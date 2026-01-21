<footer class="bg-zinc-950 text-zinc-400 py-16 border-t border-zinc-800/50 relative overflow-hidden">
    {{-- Decorative Background Elements --}}
    <div
        class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary-600/5 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2">
    </div>
    <div
        class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-600/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 mb-16">
            {{-- Brand Section --}}
            <div class="lg:col-span-4 max-w-sm">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2.5 mb-6 group">
                    <div
                        class="w-10 h-10 bg-primary-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary-600/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-black font-display text-white tracking-tight">Scholar<span
                            class="text-primary-500">peep</span></span>
                </a>
                <p class="text-zinc-400 leading-relaxed font-medium mb-8">
                    Empowering students to find and secure life-changing scholarship opportunities worldwide. Your
                    academic journey starts with a single click.
                </p>
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-2">
                        @foreach([1, 2, 3, 4] as $i)
                            <div
                                class="w-8 h-8 rounded-full border-2 border-zinc-900 bg-zinc-800 flex items-center justify-center overflow-hidden">
                                <img src="https://i.pravatar.cc/100?u={{ $i }}" alt="User"
                                    class="w-full h-full object-cover grayscale opacity-80 hover:grayscale-0 hover:opacity-100 transition duration-300"
                                    loading="lazy">
                            </div>
                        @endforeach
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-zinc-500">Joined by <span
                            class="text-zinc-300">25k+</span> students</p>
                </div>
            </div>

            {{-- Links Grid --}}
            <div class="lg:col-span-8 grid grid-cols-2 md:grid-cols-3 gap-8">
                <div>
                    <h3
                        class="text-white font-black text-xs uppercase tracking-widest mb-6 px-1 border-l-2 border-primary-500">
                        Explore</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('scholarships.index') }}" wire:navigate
                                class="text-sm font-bold hover:text-primary-400 transition flex items-center gap-2 group">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-zinc-700 group-hover:bg-primary-500 transition-colors"></span>
                                Find Scholarships
                            </a></li>
                        <li><a href="#"
                                class="text-sm font-bold hover:text-primary-400 transition flex items-center gap-2 group">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-zinc-700 group-hover:bg-primary-500 transition-colors"></span>
                                By Country
                            </a></li>
                        <li><a href="#"
                                class="text-sm font-bold hover:text-primary-400 transition flex items-center gap-2 group">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-zinc-700 group-hover:bg-primary-500 transition-colors"></span>
                                Recently Added
                            </a></li>
                    </ul>
                </div>

                <div>
                    <h3
                        class="text-white font-black text-xs uppercase tracking-widest mb-6 px-1 border-l-2 border-purple-500">
                        Resources</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('blog.index') }}" wire:navigate
                                class="text-sm font-bold hover:text-primary-400 transition flex items-center gap-2 group">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-zinc-700 group-hover:bg-purple-500 transition-colors"></span>
                                Latest News
                            </a></li>
                        <li><a href="{{ route('success-stories.index') }}" wire:navigate
                                class="text-sm font-bold hover:text-primary-400 transition flex items-center gap-2 group">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-zinc-700 group-hover:bg-purple-500 transition-colors"></span>
                                Student Stories
                            </a></li>
                        <li><a href="{{ route('resources.index') }}" wire:navigate
                                class="text-sm font-bold hover:text-primary-400 transition flex items-center gap-2 group">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-zinc-700 group-hover:bg-purple-500 transition-colors"></span>
                                Guides & Tools
                            </a></li>
                    </ul>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <h3
                        class="text-white font-black text-xs uppercase tracking-widest mb-6 px-1 border-l-2 border-emerald-500">
                        Company</h3>
                    <ul class="space-y-4">
                        <li><a href="#"
                                class="text-sm font-bold hover:text-primary-400 transition flex items-center gap-2 group">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-zinc-700 group-hover:bg-emerald-500 transition-colors"></span>
                                About Us
                            </a></li>
                        <li><a href="#"
                                class="text-sm font-bold hover:text-primary-400 transition flex items-center gap-2 group">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-zinc-700 group-hover:bg-emerald-500 transition-colors"></span>
                                Contact Support
                            </a></li>
                        <li><a href="#"
                                class="text-sm font-bold hover:text-primary-400 transition flex items-center gap-2 group">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-zinc-700 group-hover:bg-emerald-500 transition-colors"></span>
                                Privacy Policy
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Newsletter Section --}}
        <div class="bg-zinc-900 border border-zinc-800 rounded-[2rem] p-8 md:p-12 mb-16 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform duration-700">
                <svg class="w-24 h-24 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                </svg>
            </div>
            <div class="max-w-xl relative z-10">
                <h4 class="text-2xl font-black text-white font-display mb-3">Get Weekly Deadlines 📨</h4>
                <p class="text-zinc-400 font-medium mb-8">Join 15,000+ students receiving curated scholarship alerts
                    directly in their inbox every Monday.</p>
                <form class="flex flex-col sm:flex-row gap-3">
                    <input type="email" placeholder="Enter your email address..."
                        class="flex-1 bg-zinc-800 border-zinc-700 rounded-2xl px-6 py-4 text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    <button type="submit"
                        class="bg-primary-600 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-primary-700 transition shadow-lg shadow-primary-600/20 active:scale-95 whitespace-nowrap">
                        Subscribe Now
                    </button>
                </form>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="pt-8 border-t border-zinc-800/50 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-8">
                <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">
                    &copy; {{ date('Y') }} Scholarpeep.
                </p>
                <div class="flex items-center gap-6">
                    <a href="#"
                        class="text-[10px] font-black uppercase tracking-widest text-zinc-600 hover:text-zinc-400 transition">Terms</a>
                    <a href="#"
                        class="text-[10px] font-black uppercase tracking-widest text-zinc-600 hover:text-zinc-400 transition">Privacy</a>
                    <a href="#"
                        class="text-[10px] font-black uppercase tracking-widest text-zinc-600 hover:text-zinc-400 transition">Cookies</a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="#"
                    class="w-10 h-10 rounded-xl bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-500 hover:text-white hover:bg-zinc-800 hover:border-zinc-700 transition duration-300">
                    <span class="sr-only">Twitter</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
                <a href="#"
                    class="w-10 h-10 rounded-xl bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-500 hover:text-white hover:bg-zinc-800 hover:border-zinc-700 transition duration-300">
                    <span class="sr-only">LinkedIn</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                    </svg>
                </a>
                <a href="#"
                    class="w-10 h-10 rounded-xl bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-500 hover:text-white hover:bg-zinc-800 hover:border-zinc-700 transition duration-300">
                    <span class="sr-only">Instagram</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.058-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>