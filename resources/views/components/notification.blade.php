<div x-data="{ show: false, message: '' }"
    x-on:notify.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
    x-show="show" x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-0 right-0 z-50 m-6 w-full max-w-sm rounded-2xl bg-white p-4 shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center gap-4"
    style="display: none;">
    <!-- Success Icon -->
    <div class="flex-shrink-0">
        <div class="h-10 w-10 rounded-full bg-primary-50 flex items-center justify-center border border-primary-100">
            <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
    </div>
    <!-- Message -->
    <div class="flex-1">
        <p class="text-sm font-black text-gray-900" x-text="message"></p>
    </div>
    <!-- Close Button -->
    <div class="flex-shrink-0">
        <button @click="show = false" class="text-gray-400 hover:text-gray-500 transition-colors">
            <span class="sr-only">Close</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>