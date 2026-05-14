{{-- Table --}}
<div>
    <div x-data wire:ignore x-init="dateRange($refs.range, $wire, @js($enableDateRange))" class="mb-4 relative w-fit">
        <input x-ref="range" type="text" placeholder="Select date range"
            class="
            w-full sm:w-64
            px-4 py-2

            bg-white
            border border-green-200
            rounded-xl

            text-sm text-gray-700
            shadow-sm

            focus:outline-none
            focus:ring-2
            focus:ring-green-500
            focus:border-green-500

            hover:border-green-300
            transition
        ">
        {{-- Loading --}}
        <div wire:loading wire:target='applyDateRange'
            class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2">
            <x-icons.loading size='16' class="text-gray-500" />
        </div>
    </div>
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
                        Time
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
                        Moisture After
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Duration
                    </th>
                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                        Water Flow
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

                        {{-- Time --}}
                        <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                            {{ $event['time']->diffForHumans() }}
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

                        {{-- Duration --}}
                        <td class="px-4 py-3 text-gray-700 font-medium">
                            {{ $event['duration'] }} s
                        </td>

                        {{-- Water Flow --}}
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-lg text-xs font-semibold">
                                {{ $event['water_flow'] }} L
                            </span>
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
    {{-- Footer --}}
    <div class="flex justify-between items-center mt-4">
        <span class="text-sm text-gray-500">Showing {{ ($page - 1) * $paginate + 1 }} to
            {{ ($page - 1) * $paginate + count($events) }} of
            {{ $total_events }} results</span>
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
                ← Prev
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
                Next →
            </button>

        </div>
    </div>
</div>
