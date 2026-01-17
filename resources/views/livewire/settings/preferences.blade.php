<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <x-settings.layout :heading="__('Match Preferences')" :subheading="__('Personalize your scholarship feed to find the best opportunities for you.')">
        <form wire:submit="savePreferences" class="space-y-8">
            {{-- Countries --}}
            <div class="bg-white rounded-[2.5rem] shadow-200/50 p-10 border border-gray-100">
                <div class="mb-8">
                    <h3 class="text-xl font-black text-gray-900 mb-2 tracking-tight">Focus Countries</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Select countries where you want
                        to study</p>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($countries as $country)
                        <label class="relative cursor-pointer group">
                            <input type="checkbox" wire:model.live="preferred_countries" value="{{ $country->id }}"
                                class="peer hidden">
                            <div
                                class="flex items-center p-4 rounded-2xl border-2 transition-all bg-gray-50 border-transparent hover:border-gray-100 peer-checked:bg-primary-50 peer-checked:border-primary-600">
                                <span
                                    class="text-sm font-bold text-gray-500 group-hover:text-gray-900 peer-checked:text-primary-700">
                                    {{ $country->name }}
                                </span>
                            </div>
                            <div class="absolute top-3 right-3 hidden peer-checked:block">
                                <div class="w-4 h-4 rounded-full bg-primary-600 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Education Levels --}}
            <div class="bg-white rounded-[2.5rem] shadow-200/50 p-10 border border-gray-100">
                <div class="mb-8">
                    <h3 class="text-xl font-black text-gray-900 mb-2 tracking-tight">Academic Level</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">What level of education are you
                        pursuing?</p>
                </div>

                <div class="flex flex-wrap gap-4">
                    @foreach($levels as $level)
                        <label class="relative cursor-pointer group">
                            <input type="checkbox" wire:model.live="preferred_education_levels" value="{{ $level->id }}"
                                class="peer hidden">
                            <div
                                class="flex items-center px-8 py-4 rounded-full border-2 transition-all bg-gray-50 border-transparent hover:border-gray-100 peer-checked:bg-primary-50 peer-checked:border-primary-600">
                                <span
                                    class="text-sm font-bold text-gray-500 group-hover:text-gray-900 peer-checked:text-primary-700">
                                    {{ $level->name }}
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Scholarship Types --}}
            <div class="bg-white rounded-[2.5rem] shadow-200/50 p-10 border border-gray-100">
                <div class="mb-8">
                    <h3 class="text-xl font-black text-gray-900 mb-2 tracking-tight">Scholarship Types</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Filter by merit, need-based, or
                        specific categories</p>
                </div>

                <div class="flex flex-wrap gap-4">
                    @foreach($types as $type)
                        <label class="relative cursor-pointer group">
                            <input type="checkbox" wire:model.live="preferred_scholarship_types" value="{{ $type->id }}"
                                class="peer hidden">
                            <div
                                class="flex items-center px-8 py-4 rounded-full border-2 transition-all bg-gray-50 border-transparent hover:border-gray-100 peer-checked:bg-primary-50 peer-checked:border-primary-600">
                                <span
                                    class="text-sm font-bold text-gray-500 group-hover:text-gray-900 peer-checked:text-primary-700">
                                    {{ $type->name }}
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-6 pt-4">
                <button type="submit"
                    class="px-12 py-5 bg-primary-600 text-white rounded-full font-black text-sm uppercase tracking-widest hover:bg-primary-700 transition-all active:scale-95 shadow-xl shadow-primary-600/10">
                    {{ __('Save Preferences') }}
                </button>
            </div>
        </form>
    </x-settings.layout>
</div>