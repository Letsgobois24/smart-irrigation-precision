<main>
    <div x-data="{ dateInput: null }"
        class="
        flex flex-col sm:flex-row
        sm:items-center
        gap-3
        mb-4
    ">
        {{-- Date Range --}}
        <div x-data wire:ignore x-init="$nextTick(() => dateInput = dateRange($refs.range, $wire, @js($enableDateRange)))" class="relative">
            <input x-ref="range" type="text" placeholder="Filter irrigation data..."
                class="
                w-full sm:w-72

                pl-11 pr-10 py-2.5

                bg-white/90
                border border-emerald-200
                rounded-2xl

                text-sm text-gray-700
                placeholder:text-gray-400

                shadow-sm
                backdrop-blur-sm

                focus:outline-none
                focus:ring-2
                focus:ring-emerald-500/30
                focus:border-emerald-500

                hover:border-emerald-300
                transition-all
            ">

            {{-- Calendar Icon --}}
            <div
                class="
                absolute left-4 top-1/2
                -translate-y-1/2
                text-emerald-600
            ">
                <x-icons.calendar size="18" />
            </div>

            {{-- Loading --}}
            <div wire:loading wire:target="applyDateRange"
                class="
                pointer-events-none
                absolute right-3 top-1/2
                -translate-y-1/2
            ">
                <x-icons.loading size="16" class="text-gray-500" />
            </div>
        </div>

        {{-- Show All / Reset --}}
        <button wire:click="showAll" @click='dateInput.clear()' type="button"
            class="
            inline-flex items-center justify-center
            gap-2

            px-4 py-2.5

            rounded-2xl

            bg-emerald-50
            border border-emerald-200

            text-sm font-medium text-emerald-700

            hover:bg-emerald-100
            hover:border-emerald-300

            active:scale-[0.98]

            transition-all cursor-pointer
        ">
            <x-icons.refresh wire:loading.class='animate-spin' wire:target='showAll' size="16" />
            <span>Show All</span>
        </button>
    </div>
    {{-- Table --}}
    <div class="overflow-x-auto rounded-xl border border-gray-100">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-green-50 text-green-800">
                <tr>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Tree
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Valve
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Current Before
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Current Avg
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Current After 2s
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Moisture Before
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Duration
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Moisture After
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Water Flow
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Time
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse ($events as $event)
                    <tr class="hover:bg-gray-50 transition">

                        {{-- Tree ID --}}
                        <td class="px-4 py-3 flex justify-center">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg text-xs font-semibold">
                                {{ $event['tree_id'] }}
                            </span>
                        </td>

                        {{-- Valve --}}
                        <td class="px-4 py-3">
                            @if ($event['valve'])
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg text-xs font-semibold">
                                    ON
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-lg text-xs font-semibold">
                                    OFF
                                </span>
                            @endif
                        </td>

                        {{-- Current Before --}}
                        <td class="px-4 py-3 font-medium text-gray-700">
                            {{ $event['current_before'] }} mA
                        </td>

                        {{-- Current Avg --}}
                        <td class="px-4 py-3 font-medium text-blue-600">
                            {{ $event['current_avg'] }} mA
                        </td>

                        {{-- Current After 2s --}}
                        <td class="px-4 py-3 font-medium text-gray-700">
                            {{ $event['current_after_2s'] }} mA
                        </td>

                        {{-- Moisture Before --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full"
                                        style="width: {{ $event['moisture_before'] }}%">
                                    </div>
                                </div>

                                <span class="text-xs font-semibold text-gray-700">
                                    {{ $event['moisture_before'] }}%
                                </span>
                            </div>
                        </td>

                        {{-- Duration --}}
                        <td class="px-4 py-3 text-gray-700 font-medium">
                            {{ $event['duration'] }} s
                        </td>

                        {{-- Moisture After 10m --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full"
                                        style="width: {{ $event['moisture_after_10m'] }}%">
                                    </div>
                                </div>

                                <span class="text-xs font-semibold text-gray-700">
                                    {{ $event['moisture_after_10m'] }}%
                                </span>
                            </div>
                        </td>

                        {{-- Water Flow --}}
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-lg text-xs font-semibold">
                                {{ $event['water_flow'] }} L
                            </span>
                        </td>
                        {{-- Time --}}
                        <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                            {{ smartTimeFormat($event['time']) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-10 text-gray-400">
                            Tidak ada data system event
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
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
                <span wire:loading.remove wire:target='nextPage, previousPage'>Page {{ $page }}</span>
                <x-icons.loading size='20' wire:loading wire:target='nextPage, previousPage' />
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
