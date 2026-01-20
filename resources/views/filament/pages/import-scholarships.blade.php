<x-filament-panels::page>
    <form wire:submit="submit">
        {{ $this->form }}

        <div class="mt-6 flex items-center justify-end gap-3">
            <x-filament::button type="submit" size="lg">
                Start Import
            </x-filament::button>
        </div>
    </form>

    <div class="mt-8">
        <x-filament::section>
            <x-slot name="heading">
                CSV Format Guide
            </x-slot>

            <p class="text-sm text-gray-600 mb-4">
                Ensure your CSV file has the following headers (case-insensitive):
            </p>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Column</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Required</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr>
                            <td class="px-4 py-2 text-sm font-mono text-primary-600">title</td>
                            <td class="px-4 py-2 text-sm text-red-500 font-bold">Yes</td>
                            <td class="px-4 py-2 text-sm text-gray-600">Name of the scholarship</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-sm font-mono text-primary-600">provider</td>
                            <td class="px-4 py-2 text-sm text-gray-400">No</td>
                            <td class="px-4 py-2 text-sm text-gray-600">Organization offering the scholarship</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-sm font-mono text-primary-600">url</td>
                            <td class="px-4 py-2 text-sm text-gray-400">No</td>
                            <td class="px-4 py-2 text-sm text-gray-600">Application link</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-sm font-mono text-primary-600">amount</td>
                            <td class="px-4 py-2 text-sm text-gray-400">No</td>
                            <td class="px-4 py-2 text-sm text-gray-600">Monetary value (numeric)</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-sm font-mono text-primary-600">deadline</td>
                            <td class="px-4 py-2 text-sm text-gray-400">No</td>
                            <td class="px-4 py-2 text-sm text-gray-600">Format: YYYY-MM-DD</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-sm font-mono text-primary-600">countries</td>
                            <td class="px-4 py-2 text-sm text-gray-400">No</td>
                            <td class="px-4 py-2 text-sm text-gray-600">Comma-separated list of country names</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>