<div
    class="{{ $statusConfig['card'] }} bg-white border-l-6 border-t border-r border-b p-3 rounded-xl transition-all duration-300">

    <!-- Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-2">
            🌱

            <p class="text-sm text-gray-600">
                Tree {{ $tree['tree_id'] }}
            </p>
        </div>
        <x-ui.badge size='xs' :color="$statusConfig['badge_color']">
            {{ $statusConfig['badge'] }}
        </x-ui.badge>
    </div>

    <!-- Moisture -->
    <div class="flex items-center gap-2">
        <x-icons.humidity size="20" class="{{ $statusConfig['icon'] }}" />
        <p class="text-lg font-bold">
            {{ round($tree['soil_moisture'], 2) }}%
        </p>
    </div>

    <!-- Valve -->
    <div class="flex items-center gap-1 mt-2">
        ⚙️
        <p
            class="
            text-xs font-medium
            {{ $tree['valve'] ? 'text-green-600' : 'text-gray-500' }}
        ">
            Valve
            <x-ui.badge :color="$tree['valve'] ? 'green' : 'red'" size="1">
                {{ $tree['valve'] ? 'ON' : 'OFF' }}
            </x-ui.badge>
        </p>
    </div>

    <!-- Status -->
    <div class="mt-2 text-xs">
        <p class="{{ $statusConfig['description_color'] }}">
            {{ $statusConfig['description'] }}
        </p>
    </div>

    <!-- Last Update -->
    <div class="mt-3 text-xs text-gray-400 flex flex-wrap gap-x-1">
        <span>Last update:</span>
        <span>
            {{ smartTimeFormat($tree['time']) }}
        </span>
    </div>

    {{-- Status Anomali --}}
    <div x-on:click="$dispatch('filter-location', {tree_id: @js($tree['tree_id'])})"
        class="flex items-center justify-between mt-3 cursor-pointer">

        <div class="flex items-center gap-2">
            @if ($faultConfig['icon'] === 'warning')
                <x-icons.warning size="16" class="{{ $faultConfig['text_color'] }}" />
            @else
                <x-icons.check size="16" class="{{ $faultConfig['text_color'] }}" />
            @endif

            <span class="text-xs {{ $faultConfig['text_color'] }}">
                @if ($tree['total_anomaly'] > 0)
                    {{ $tree['total_anomaly'] }} Gangguan Aktif
                @else
                    Kondisi Normal
                @endif
            </span>
        </div>

    </div>
</div>
