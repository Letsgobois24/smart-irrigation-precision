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
        <table class="min-w-full text-sm text-left border-collapse">
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
                    @php
                        /*
            |--------------------------------------------------------------------------
            | Current State
            |--------------------------------------------------------------------------
            */
                        $currentStable = $event['current_stable'];
                        $currentDelta = $event['current_delta'];

                        $isCurrentFlowing = $currentStable > 0;

                        /*
            |--------------------------------------------------------------------------
            | Moisture Status
            |--------------------------------------------------------------------------
            | < 30   = Dry -> yellow
            | 30-70  = Normal -> green
            | > 70   = Too Wet -> blue
            */
                        $moistureBefore = $event['moisture_before'];
                        $moistureAfter = $event['moisture_after'];

                        $beforeStatus = $moistureBefore < 30 ? 'dry' : ($moistureBefore > 70 ? 'wet' : 'normal');

                        $afterStatus = $moistureAfter < 30 ? 'dry' : ($moistureAfter > 70 ? 'wet' : 'normal');

                        /*
            |--------------------------------------------------------------------------
            | Anomaly
            |--------------------------------------------------------------------------
            */
                        $isAnomaly = $event['anomaly_flag'];

                    @endphp

                    <tr class="hover:bg-gray-50 transition font-mono">

                        {{-- Tree ID --}}
                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size='sm' color="green">
                                {{ $event['tree_id'] }}
                            </x-ui.badge>
                        </td>

                        {{-- Valve --}}
                        <td class="px-4 py-3 font-sans border-r border-green-200">
                            <x-ui.badge size='sm' :color="$event['valve'] ? 'green' : 'red'">
                                {{ $event['valve'] ? 'ON' : 'OFF' }}
                            </x-ui.badge>
                        </td>

                        {{-- Current Before --}}
                        <td
                            class="px-4 py-3 font-medium {{ $event['current_before'] < 1 ? 'text-gray-700' : 'text-blue-700' }}">
                            {{ number_format($event['current_before'], 1) }}
                        </td>

                        {{-- Duration --}}
                        <td class="px-4 py-3 text-gray-700 font-medium whitespace-nowrap">
                            {{ number_format($event['current_stable_duration'], 2) }} s
                        </td>

                        {{-- Current Stable --}}
                        <td
                            class="px-4 py-3 font-medium {{ $event['current_stable'] < 1 ? 'text-gray-700' : 'text-blue-700' }}">
                            {{ number_format($event['current_stable'], 1) }}
                        </td>

                        {{-- Current Delta --}}
                        <td class="px-4 py-3">
                            <x-ui.badge size='sm' :color="$currentDelta > 0 ? 'green' : 'red'">
                                {{ sprintf('%+.1f', number_format($currentDelta, 1)) }}
                            </x-ui.badge>
                        </td>

                        {{-- Current Average --}}
                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size='sm' color="gray">
                                {{ number_format($event['current_avg'], 1) }}
                            </x-ui.badge>
                        </td>

                        {{-- Moisture Before --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">

                                <div class="w-16 bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="h-2 rounded-full
                            {{ $beforeStatus === 'dry' ? 'bg-orange-500' : ($beforeStatus === 'wet' ? 'bg-blue-500' : 'bg-green-500') }}"
                                        style="width: {{ $moistureBefore }}%">
                                    </div>
                                </div>

                                <x-ui.badge size='sm' :color="$beforeStatus === 'dry' ? 'yellow' : ($beforeStatus === 'wet' ? 'blue' : 'green')">
                                    {{ number_format($event['moisture_before'], 1) }}%
                                </x-ui.badge>
                            </div>
                        </td>

                        {{-- Moisture Duration --}}
                        <td class="px-4 py-3 text-gray-700 font-medium">
                            {{ $event['moisture_duration'] }} s
                        </td>

                        {{-- Moisture After --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">

                                <div class="w-16 bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="h-2 rounded-full
                            {{ $afterStatus === 'dry' ? 'bg-orange-500' : ($afterStatus === 'wet' ? 'bg-blue-500' : 'bg-green-500') }}"
                                        style="width: {{ $moistureAfter }}%">
                                    </div>
                                </div>

                                <x-ui.badge size='sm' :color="$afterStatus === 'dry' ? 'yellow' : ($afterStatus === 'wet' ? 'blue' : 'green')">
                                    {{ number_format($event['moisture_after'], 1) }}%
                                </x-ui.badge>

                            </div>
                        </td>

                        {{-- Moisture Delta --}}
                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size='sm' :color="$event['moisture_delta'] > 0 ? 'green' : 'red'">
                                {{ sprintf('%+.1f', number_format($event['moisture_delta'], 1)) }}%
                            </x-ui.badge>
                        </td>

                        {{-- Anomaly Flag --}}
                        <td class="px-4 py-3 font-sans">
                            <x-ui.badge size='sm' :color="$isAnomaly ? 'red' : 'green'">
                                {{ $isAnomaly ? 'Anomaly' : 'Normal' }}
                            </x-ui.badge>
                        </td>

                        {{-- Anomaly Score --}}
                        <td class="px-4 py-3 border-r border-green-200">
                            <x-ui.badge size='sm' :color="$event['anomaly_score'] >= 70
                                ? 'red'
                                : ($event['anomaly_score'] >= 40
                                    ? 'yellow'
                                    : 'green')">
                                {{ $event['anomaly_score'] }}%
                            </x-ui.badge>
                        </td>

                        {{-- Time --}}
                        <td class="px-4 py-3 font-sans text-gray-500 whitespace-nowrap">
                            {{ smartTimeFormat($event['time']) }}
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="14" class="text-center py-10 text-gray-400">
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
