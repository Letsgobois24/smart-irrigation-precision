<div x-data="{ dateInput: null }">
    <div class="flex flex-col sm:flex-row sm:items-stretch gap-3 mb-4">

        {{-- Date Range --}}
        <x-form.date-range :date_range="$date_range" placeholder="Filter energy data..." />

        {{-- Active Source --}}
        <x-form.select model="selected_active_source" :data="$active_sources" disabled_option="Active Source" />

        {{-- Switch Status --}}
        <x-form.select model="selected_switch_status" :data="$switch_statuses" disabled_option="Switch Status" />

        {{-- Reset --}}
        <x-ui.button.show-all click="showAll" @click="dateInput.clear()" />

    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-xl border border-gray-100">
        <table class="table-fixed min-w-full text-sm text-left border-collapse">
            <thead class="bg-green-50 text-green-800 text-center">
                <tr class="border-b border-green-100">
                    <th class="px-4 py-3">Active Source</th>
                    <th class="px-4 py-3">Switch Status</th>
                    <th class="px-4 py-3">Battery SOC</th>
                    <th class="px-4 py-3">Battery Voltage</th>
                    <th class="px-4 py-3">Load Power</th>
                    <th class="px-4 py-3">Time</th>
                </tr>
            </thead>

            <tbody wire:loading.remove class="divide-y divide-gray-100">

                @forelse($data as $row)
                    <tr class="hover:bg-gray-50 transition text-center">

                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size="sm" :color="$row['active_source'] == 'PLN'
                                ? 'green'
                                : ($row['active_source'] == 'Battery'
                                    ? 'yellow'
                                    : 'blue')">
                                {{ $row['active_source'] }}
                            </x-ui.badge>
                        </td>

                        <td class="px-4 py-3 border-r border-green-200">

                            <x-ui.badge size="sm" :color="$row['switch_status'] == 'Switching' ? 'yellow' : 'green'">

                                {{ $row['switch_status'] }}

                            </x-ui.badge>

                        </td>

                        <td class="px-4 py-3 border-r border-green-200">
                            {{ number_format($row['battery_soc'], 1) }} %
                        </td>

                        <td class="px-4 py-3 border-r border-green-200">
                            {{ number_format($row['battery_voltage'], 2) }} V
                        </td>

                        <td class="px-4 py-3 border-r border-green-200">
                            {{ number_format($row['load_power'], 2) }} W
                        </td>

                        <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                            {{ smartTimeFormat($row['time']) }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-400">
                            Tidak ada data yang tersedia.
                        </td>
                    </tr>
                @endforelse

            </tbody>
            <x-placeholder.table-body columns='5' rows='5' td-class='border-r border-green-200'
                class="divide-y divide-gray-100 hidden" />
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex sm:flex-row flex-col-reverse sm:justify-between items-center mt-4 gap-3">
        {{-- Pagination count --}}
        <span class="text-sm text-gray-500">Showing {{ ($page - 1) * $paginate + 1 }} to
            {{ ($page - 1) * $paginate + count($data) }}</span>
        {{-- Pagination button --}}
        <div class="flex items-center gap-2">
            {{-- LEFT --}}
            <button wire:click="previousPage" wire:loading.attr="disabled" wire:target="previousPage"
                @disabled($page <= 1)
                class="
                px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition
                flex items-center gap-2
    
                {{ $page <= 1
                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                    : 'bg-white border border-gray-200 hover:bg-gray-100 text-gray-700 cursor-pointer' }}
            ">
                ← <span class="hidden sm:block">Prev</span>
            </button>

            {{-- Page Indicator --}}
            <div class="w-16 h-4 inline-flex justify-center items-center text-sm text-gray-500 font-medium">
                Page {{ $page }}
            </div>

            {{-- RIGHT --}}
            <button wire:click="nextPage" wire:loading.attr="disabled" wire:target="nextPage"
                @disabled($isLast)
                class="
                px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition
                flex items-center gap-2
    
                {{ $isLast
                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                    : 'bg-green-600 hover:bg-green-700 text-white cursor-pointer' }}
            ">
                <span class="hidden sm:block">Next</span> →
            </button>

        </div>
    </div>
</div>
