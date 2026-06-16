<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
    <!-- PH -->
    <x-card.global-card :config="$ph_config" :data="$globalData['ph']">
        <x-slot name="icon">
            <x-icons.ph size="28" />
        </x-slot>
    </x-card.global-card>

    <!-- WATER FLOW -->
    <x-card.global-card :config="$flow_config" :data="$globalData['water_flow'] . ' L/min'">
        <x-slot name="icon">
            <x-icons.water-flow size="28" />
        </x-slot>
    </x-card.global-card>

    {{-- LIGHT --}}
    <x-card.global-card :config="$light_config" :data="$globalData['light'] . ' %'">
        <x-slot name="icon">
            <x-icons.sun size="24" />
        </x-slot>
    </x-card.global-card>

    <!-- WATER PUMP -->
    <x-card.global-card :config="$water_pump_config" :data="$globalData['water_pump'] ? 'ON' : 'OFF'">
        <x-slot name="icon">
            <x-icons.pump size="28" />
        </x-slot>
    </x-card.global-card>

    <!-- FERTILIZER PUMP -->
    <x-card.global-card :config="$fertilizer_pump_config" :data="$globalData['fertilizer_pump'] ? 'ON' : 'OFF'">
        <x-slot name="icon">
            <x-icons.flask size="28" />
        </x-slot>
    </x-card.global-card>

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
