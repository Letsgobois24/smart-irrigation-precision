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
    <x-card.global-card :config="$last_update_config" :data="$globalData['time']->diffForHumans()">
        <x-slot name="icon">
            <x-icons.clock size="26" />
        </x-slot>
    </x-card.global-card>

</div>
