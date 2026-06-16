<div x-data="{ dateInput: null }">
    <div class="flex flex-col sm:flex-row sm:items-stretch gap-3 mb-4">
        {{-- Date Range --}}
        <x-form.date-range :date_range="$date_range" placeholder="Filter irrigation data..." />

        {{-- Show All / Reset --}}
        <x-ui.button.show-all click="showAll" @click='dateInput.clear()' />
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-xl border border-gray-100">
        <table class="table-fixed min-w-full text-sm text-left border-collapse">
            <thead class="bg-green-50 text-green-800 text-center">

                {{-- Sub Header --}}
                <tr class="border-b border-green-100">
                    {{-- Current --}}
                    <th class="px-4 py-3 whitespace-nowrap">
                        pH
                    </th>
                    <th class="px-4 py-3 whitespace-nowrap">
                        Water Flow (L/min)
                    </th>
                    <th class="px-4 py-3 whitespace-nowrap">
                        Water Pump
                    </th>
                    <th class="px-4 py-3 whitespace-nowrap">
                        Fertilizer Pump
                    </th>
                    <th class="px-4 py-3 whitespace-nowrap">
                        Time
                    </th>
                </tr>
            </thead>

            <tbody wire:loading.remove class="divide-y divide-gray-100 table-row-group">
                @forelse ($data as $row)
                    <tr class="hover:bg-gray-50 transition font-mono text-center">
                        {{-- pH --}}
                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size='sm' :color="$this->pHColor($row['ph'])">
                                {{ number_format($row['ph'], 1) }}
                            </x-ui.badge>
                        </td>
                        {{-- Water Flow --}}
                        <td
                            class="px-4 py-3 font-medium border-r border-green-200 {{ $row['water_flow'] < 0.1 ? 'text-gray-700' : 'text-blue-700' }}">
                            {{ number_format($row['water_flow'], 1) }}
                        </td>
                        {{-- Water Pump --}}
                        <td class="px-4 py-3 font-sans border-r border-green-200">
                            <x-ui.badge size='sm' :color="$row['water_pump'] ? 'green' : 'red'">
                                {{ $row['water_pump'] ? 'ON' : 'OFF' }}
                            </x-ui.badge>
                        </td>
                        {{-- Fertilizer Pump --}}
                        <td class="px-4 py-3 font-sans border-r border-green-200">
                            <x-ui.badge size='sm' :color="$row['fertilizer_pump'] ? 'green' : 'red'">
                                {{ $row['fertilizer_pump'] ? 'ON' : 'OFF' }}
                            </x-ui.badge>
                        </td>
                        {{-- Time --}}
                        <td class="px-4 py-3 font-sans text-gray-500 whitespace-nowrap">
                            {{ smartTimeFormat($row['time']) }}
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="14" class="text-center py-10 text-gray-400">
                            Tidak ada data yang tersedia
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
