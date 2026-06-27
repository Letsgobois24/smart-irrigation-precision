<div x-data="{ dateInput: null }">
    <div class="flex flex-col sm:flex-row sm:items-stretch gap-3 mb-4">

        {{-- Date Range --}}
        <x-form.date-range :date_range="$date_range" placeholder="Filter energy data..." />

        {{-- Active Source --}}
        <x-form.select model="selected_source" :data="$sources" disabled_option="Active Source" />

        {{-- Event --}}
        <x-form.select model="selected_event" :data="$events" disabled_option="Event" />

        {{-- Reset --}}
        <x-ui.button.show-all click="showAll" @click="dateInput.clear()" />

    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-xl border border-gray-100">
        <table class="table-fixed min-w-full text-sm text-left border-collapse">
            <thead class="bg-green-50 text-green-800 text-center">

                <tr class="border-b border-green-200">
                    <th rowspan="2" class="px-4 py-3 border-r border-green-200">Source</th>
                    <th rowspan="2" class="px-4 py-3 border-r border-green-200">Event</th>

                    <th colspan="2" class="px-4 py-2 border-r border-green-200">
                        Battery
                    </th>

                    <th colspan="2" class="px-4 py-2 border-r border-green-200">
                        Load
                    </th>

                    <th colspan="3" class="px-4 py-2 border-r border-green-200">
                        PV
                    </th>

                    <th rowspan="2" class="px-4 py-3">
                        Time
                    </th>
                </tr>

                <tr class="border-b border-green-100 text-xs uppercase tracking-wide">

                    <th class="px-3 py-2 border-r border-green-100">
                        SOC (%)
                    </th>

                    <th class="px-3 py-2 border-r border-green-200">
                        Voltage (V)
                    </th>

                    <th class="px-3 py-2 border-r border-green-100">
                        Current (A)
                    </th>

                    <th class="px-3 py-2 border-r border-green-200">
                        Power (W)
                    </th>

                    <th class="px-3 py-2 border-r border-green-100">
                        Voltage (V)
                    </th>

                    <th class="px-3 py-2 border-r border-green-100">
                        Current (A)
                    </th>

                    <th class="px-3 py-2 border-r border-green-200">
                        Power (W)
                    </th>

                </tr>

            </thead>

            <tbody wire:loading.remove class="divide-y divide-gray-100">

                @forelse($data as $row)
                    <tr class="hover:bg-gray-50 transition text-center">

                        {{-- Source --}}
                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size="sm" :color="$row['source'] == 'PLN'
                                ? 'green'
                                : ($row['source'] == 'Battery'
                                    ? 'yellow'
                                    : 'blue')">
                                {{ $row['source'] }}
                            </x-ui.badge>
                        </td>

                        {{-- Event --}}
                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size="sm" :color="$row['event'] == 'switching' ? 'yellow' : 'green'">
                                {{ $events[$row['event']] ?? $row['event'] }}
                            </x-ui.badge>
                        </td>

                        {{-- Battery --}}
                        <td class="px-4 py-3 border-r border-green-100">
                            <x-ui.badge size="sm" :color="$this->getBadgeColor('battery_soc', $row['battery_soc'])">
                                {{ number_format($row['battery_soc'], 1) }} %
                            </x-ui.badge>
                        </td>
                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size="sm" :color="$this->getBadgeColor('battery_voltage', $row['battery_voltage'])">
                                {{ number_format($row['battery_voltage'], 2) }} V
                            </x-ui.badge>
                        </td>

                        {{-- Load --}}
                        <td class="px-4 py-3 border-r border-green-100">
                            <x-ui.badge size="sm" :color="$this->getBadgeColor('load_current', $row['load_current'])">
                                {{ number_format($row['load_current'], 2) }} A
                            </x-ui.badge>
                        </td>

                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size="sm" :color="$this->getBadgeColor('load_power', $row['load_power'])">
                                {{ number_format($row['load_power'], 2) }} W
                            </x-ui.badge>
                        </td>

                        {{-- PV --}}
                        <td class="px-4 py-3 border-r border-green-100">
                            <x-ui.badge size="sm" :color="$this->getBadgeColor('pv_voltage', $row['pv_voltage'])">
                                {{ number_format($row['pv_voltage'], 2) }} V
                            </x-ui.badge>
                        </td>

                        <td class="px-4 py-3 border-r border-green-100">
                            <x-ui.badge size="sm" :color="$this->getBadgeColor('pv_current', $row['pv_current'])">
                                {{ number_format($row['pv_current'], 2) }} A
                            </x-ui.badge>
                        </td>

                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size="sm" :color="$this->getBadgeColor('pv_power', $row['pv_power'])">
                                {{ number_format($row['pv_power'], 2) }} W
                            </x-ui.badge>
                        </td>

                        {{-- Time --}}
                        <td class="px-4 py-3 whitespace-nowrap text-gray-500">
                            {{ smartTimeFormat($row['time']) }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="10" class="py-10 text-center text-gray-400">
                            Tidak ada data yang tersedia.
                        </td>
                    </tr>
                @endforelse

            </tbody>
            <x-placeholder.table-body columns='10' rows='5' td-class='border-r border-green-200'
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
