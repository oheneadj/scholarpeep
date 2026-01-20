<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/20 border border-gray-100 overflow-hidden">
        <div class="p-8 sm:p-16">
            <div class="mb-12">
                <h1 class="text-4xl font-black text-gray-900 tracking-tight font-display mb-3">Share Your Success Story
                </h1>
                <p class="text-gray-500 font-medium text-lg">Inspire others by sharing how ScholarPeep helped you secure
                    a
                    scholarship.</p>
            </div>

            <form wire:submit.prevent="submit" class="space-y-10">
                {{-- Title --}}
                <div class="space-y-3">
                    <label for="title"
                        class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Story
                        Title</label>
                    <input type="text" id="title" wire:model="title"
                        class="w-full px-6 py-5 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 focus:bg-white transition-all font-bold text-gray-900 placeholder:text-gray-300"
                        placeholder="e.g., How I won the Fulbright Scholarship">
                    @error('title') <span class="text-rose-500 text-xs mt-1 font-bold ml-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- University --}}
                    <div class="space-y-3 relative">
                        <label for="universitySearch"
                            class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">University /
                            Institution</label>
                        <div class="relative">
                            <input type="text" id="universitySearch" wire:model.live.debounce.300ms="universitySearch"
                                class="w-full px-6 py-5 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 focus:bg-white transition-all font-bold text-gray-900 placeholder:text-gray-300"
                                placeholder="e.g., Harvard University" autocomplete="off"
                                wire:focus="$set('showUniversityResults', true)">

                            @if($showUniversityResults && !empty($universities))
                                <div
                                    class="absolute z-50 w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                                    @foreach($universities as $uni)
                                        <button type="button" wire:click="selectUniversity('{{ $uni }}')"
                                            class="w-full text-left px-6 py-4 hover:bg-primary-50 text-sm font-bold text-gray-700 transition-colors border-b border-gray-50 last:border-0">
                                            {{ $uni }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @error('university') <span
                        class="text-rose-500 text-xs mt-1 font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Country --}}
                    <div class="space-y-3 relative">
                        <label for="countrySearch"
                            class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Country</label>
                        <div class="relative">
                            <input type="text" id="countrySearch" wire:model.live.debounce.300ms="countrySearch"
                                class="w-full px-6 py-5 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 focus:bg-white transition-all font-bold text-gray-900 placeholder:text-gray-300"
                                placeholder="e.g., United States" autocomplete="off"
                                wire:focus="$set('showCountryResults', true)">

                            @if($showCountryResults && !empty($countries))
                                <div
                                    class="absolute z-50 w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                                    @foreach($countries as $c)
                                        <button type="button" wire:click="selectCountry('{{ $c->name }}')"
                                            class="w-full text-left px-6 py-4 hover:bg-primary-50 text-sm font-bold text-gray-700 transition-colors border-b border-gray-50 last:border-0 flex items-center gap-3">
                                            <span class="text-lg">{{ $c->emoji }}</span>
                                            {{ $c->name }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @error('country') <span class="text-rose-500 text-xs mt-1 font-bold ml-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Scholarship --}}
                <div class="space-y-3">
                    <label for="scholarship_id"
                        class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Associated
                        Scholarship
                        (Optional)</label>
                    <select id="scholarship_id" wire:model="scholarship_id"
                        class="w-full px-6 py-5 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 focus:bg-white transition-all font-bold text-gray-900 appearance-none">
                        <option value="">Select a scholarship you secured/applied to</option>
                        @foreach($savedScholarships as $saved)
                            <option value="{{ $saved->scholarship->id }}">{{ $saved->scholarship->title }}</option>
                        @endforeach
                    </select>
                    @error('scholarship_id') <span
                    class="text-rose-500 text-xs mt-1 font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                {{-- Story --}}
                <div class="space-y-3">
                    <label for="story"
                        class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Your
                        Story</label>
                    <textarea id="story" wire:model="story" rows="8"
                        class="w-full px-6 py-5 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 focus:bg-white transition-all font-bold text-gray-900 placeholder:text-gray-300"
                        placeholder="Tell us about your journey, the challenges you faced, and how securing the scholarship changed your life..."></textarea>
                    <div class="flex justify-between items-center mt-2 px-1">
                        @error('story') <span class="text-rose-500 text-xs font-bold">{{ $message }}</span> @enderror
                        <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Minimum 50
                            characters</span>
                    </div>
                </div>

                {{-- Photo --}}
                <div class="space-y-3">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Your Photo
                        (Optional)</label>
                    <div class="flex items-center gap-8 p-6 bg-gray-50 rounded-3xl border border-gray-100">
                        <div class="relative">
                            @if ($student_photo)
                                <img src="{{ $student_photo->temporaryUrl() }}"
                                    class="w-24 h-24 rounded-2xl object-cover shadow-2xl ring-4 ring-white">
                            @else
                                <div
                                    class="w-24 h-24 rounded-2xl bg-white flex items-center justify-center text-gray-200 border border-gray-100 shadow-sm">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" id="student_photo" wire:model="student_photo" class="hidden">
                            <label for="student_photo"
                                class="inline-flex items-center px-6 py-3 bg-white text-primary-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary-600 hover:text-white transition-all cursor-pointer border border-primary-100 shadow-sm active:scale-95">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Upload Photo
                            </label>
                            <p class="text-gray-400 text-[9px] mt-3 font-black uppercase tracking-widest">JPG, PNG up to
                                1MB</p>
                        </div>
                    </div>
                    @error('student_photo') <span
                    class="text-rose-500 text-xs mt-1 font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-10 border-t border-gray-50 flex flex-col sm:flex-row gap-4">
                    <button type="submit"
                        class="flex-1 px-10 py-6 bg-primary-600 text-white rounded-full font-black uppercase tracking-widest hover:bg-primary-700 transition-all shadow-xl shadow-primary-600/20 active:scale-95 disabled:opacity-50 flex items-center justify-center gap-3 group"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Submit My Story</span>
                        <span wire:loading>Submitting...</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="px-10 py-6 bg-gray-50 text-gray-500 rounded-full font-black uppercase tracking-widest hover:bg-gray-100 transition-all border border-gray-100 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>