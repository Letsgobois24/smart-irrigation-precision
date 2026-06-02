<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    <!-- PH -->
    <div class="rounded-2xl border shadow-sm p-4 transition 
    {{ $ph_config['border'] }}
    {{ $ph_config['bg'] }}">

        <div class="flex justify-between items-start mb-3">

            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-white {{ $ph_config['text'] }}">
                    <x-icons.ph size="28" />
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        pH Air
                    </p>

                    <h3 class="text-2xl font-bold {{ $ph_config['text'] }}">
                        {{ $globalData['ph'] }}
                    </h3>
                </div>
            </div>

            <x-ui.badge class="capitalize" :color="$ph_config['color']" size='sm'>
                {{ $ph_config['label'] }}
            </x-ui.badge>
        </div>

        {{-- Description --}}
        <p class="text-xs text-gray-600">
            {{ $ph_config['description'] }}
        </p>
    </div>

    <!-- WATER FLOW -->
    <div
        class="rounded-2xl border shadow-sm p-4 transition
        {{ $flow_config['bg'] }}
        {{ $flow_config['border'] }} 
        ">

        <div class="flex justify-between items-start mb-3">

            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-white
                    {{ $flow_config['text'] }}">
                    <x-icons.water-flow size="24" />
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Water Flow
                    </p>

                    <h3 class="text-2xl font-bold
                        {{ $flow_config['text'] }}">
                        {{ $globalData['water_flow'] }}
                        <span class="text-lg">L/min</span>
                    </h3>
                </div>
            </div>

            <x-ui.badge class="capitalize" :color="$flow_config['color']" size='sm'>
                {{ $flow_config['label'] }}
            </x-ui.badge>
        </div>

        <p class="text-xs text-gray-600">
            {{ $flow_config['description'] }}
        </p>
    </div>

    <!-- MAIN VALVE -->
    <div
        class="rounded-2xl border shadow-sm p-4 transition
    {{ $valve_config['bg'] }}
    {{ $valve_config['border'] }}">

        <div class="flex justify-between items-start mb-3">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-white {{ $valve_config['icon'] }}">
                    <x-icons.valve-off size="28" />
                </div>
                <div>
                    <p class="text-sm text-gray-500">
                        Valve
                    </p>
                    <h3 class="text-xl font-bold {{ $valve_config['text'] }}">
                        {{ $valve_config['status'] }}
                    </h3>
                </div>
            </div>
            <x-ui.badge :color="$valve_config['color']" size="2">
                {{ $valve_config['label'] }}
            </x-ui.badge>
        </div>

        <p class="text-xs text-gray-600">
            {{ $valve_config['description'] }}
        </p>
    </div>

    <!-- LAST UPDATE -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-4">

        <div class="flex justify-between items-start mb-3">

            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-gray-100 text-gray-600">
                    <x-icons.clock size="26" />
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Last Update
                    </p>

                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $globalData['time']->diffForHumans() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 text-xs text-gray-500">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            Sistem monitoring aktif
        </div>
    </div>

</div>
