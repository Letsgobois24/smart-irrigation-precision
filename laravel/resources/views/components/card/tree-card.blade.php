<div class="{{ $statusConfig['card'] }} p-3 rounded-xl transition-all duration-300">

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
            {{ $tree['soil_moisture'] }}%
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
</div>
