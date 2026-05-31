<main>
    <div x-data="{ dateInput: null }"
        class="
        flex flex-col sm:flex-row
        sm:items-stretch
        gap-3
        mb-4
">
        {{-- Date Range --}}
        <x-form.date-range :date_range="$date_range" placeholder="Filter irrigation data..." />

        {{-- Select Tree ID --}}
        <x-form.select wire:change='refreshTotalEvents' model="selected_tree" :data="$trees_id"
            disabled_option='Select Tree' />

        {{-- Show All / Reset --}}
        <button wire:click="showAll" @click='dateInput.clear()' type="button"
            class="
            inline-flex items-center justify-center
            gap-2
            px-4 py-2
            rounded-2xl
            bg-emerald-50
            border border-emerald-200
            text-sm font-medium text-emerald-700
            hover:bg-emerald-100
            hover:border-emerald-300
            active:scale-[0.98]
            transition-all cursor-pointer
            whitespace-nowrap
        ">
            <x-icons.refresh wire:loading.class='animate-spin' wire:target='showAll' size="16" />
            <span>Show All</span>
        </button>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-xl border border-gray-100">
        <table wire:loading.remove class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-green-50 text-green-800 text-center">

                {{-- Group Header --}}
                <tr class="border-b-2 border-green-200">

                    <th rowspan="2"
                        class="px-4 py-3 font-bold whitespace-nowrap align-middle text-center border-r border-green-200">
                        Tree
                    </th>

                    <th rowspan="2"
                        class="px-4 py-3 font-bold whitespace-nowrap align-middle text-center border-r border-green-200">
                        Valve
                    </th>

                    {{-- Current Group --}}
                    <th colspan="5"
                        class="px-4 py-3 font-bold text-center border-r border-green-200 bg-green-100/50">
                        ⚡ Current (mA)
                    </th>

                    {{-- Moisture Group --}}
                    <th colspan="4" class="px-4 py-3 font-bold border-r border-green-200 bg-blue-100/40">
                        💧 Moisture
                    </th>

                    {{-- Anomaly Group --}}
                    <th colspan="2" class="px-4 py-3 font-bold border-r border-green-200 bg-red-100/40">
                        🚨 Anomaly
                    </th>

                    <th rowspan="2" class="px-4 py-3 font-bold whitespace-nowrap align-middle">
                        Time
                    </th>

                </tr>

                {{-- Sub Header --}}
                <tr class="text-xs tracking-wide border-b border-green-100">

                    {{-- Current --}}
                    <th class="px-4 py-3 whitespace-nowrap">
                        Before
                    </th>

                    <th class="px-4 py-3 whitespace-nowrap">
                        Duration
                    </th>

                    <th class="px-4 py-3 whitespace-nowrap">
                        Stable
                    </th>

                    <th class="px-4 py-3 whitespace-nowrap">
                        Delta
                    </th>

                    <th class="px-4 py-3 whitespace-nowrap border-r border-green-200">
                        Average
                    </th>

                    {{-- Moisture --}}
                    <th class="px-4 py-3 whitespace-nowrap">
                        Before
                    </th>

                    <th class="px-4 py-3 whitespace-nowrap">
                        Duration
                    </th>

                    <th class="px-4 py-3 whitespace-nowrap">
                        After
                    </th>

                    <th class="px-4 py-3 whitespace-nowrap border-r border-green-200">
                        Delta
                    </th>

                    {{-- Anomaly --}}
                    <th class="px-4 py-3 whitespace-nowrap">
                        Flag
                    </th>

                    <th class="px-4 py-3 whitespace-nowrap border-r border-green-200">
                        Score
                    </th>

                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($events as $event)
                    <x-table.body-row :row="$event" />
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-10 text-gray-400">
                            Tidak ada data system event
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <x-placeholder.table columns='10' rows='5' wire:loading />
    </div>

    {{-- Pagination --}}
    <div class="flex sm:flex-row flex-col-reverse sm:justify-between items-center mt-4 gap-3">
        {{-- Pagination count --}}
        <span class="text-sm text-gray-500">Showing {{ ($page - 1) * $paginate + 1 }} to
            {{ ($page - 1) * $paginate + count($events) }} of
            {{ $total_events }} results</span>
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
