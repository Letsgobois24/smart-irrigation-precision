<div class="{{ $cardClass }} p-3 rounded-xl transition-all duration-300">
    <!-- Header -->
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-2">
            🌱
            <p class="text-sm text-gray-600">
                Tree {{ $tree['tree_id'] }}
            </p>
        </div>

        <span class="text-[10px] px-2 py-1 rounded-full font-medium {{ $badgeClass }}">
            {{ $statusText }}
        </span>
    </div>

    <!-- Moisture -->
    <div class="flex items-center gap-2">
        <x-icons.humidity size="20"
            class="
                {{ $isDry ? 'text-red-500' : '' }}
                {{ $isWet ? 'text-yellow-500' : '' }}
                {{ $isNormal ? 'text-blue-500' : '' }}
            " />

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
            Valve {{ $tree['valve'] ? 'ON' : 'OFF' }}
        </p>
    </div>

    <!-- Status Detail -->
    <div class="mt-2 text-xs">
        @if ($isDry)
            <p class="text-red-600">
                Irrigation recommended
            </p>
        @elseif ($isWet)
            <p class="text-yellow-700">
                Soil moisture too high
            </p>
        @else
            <p class="text-green-600">
                Soil condition stable
            </p>
        @endif
    </div>

    <!-- Last Update -->
    <div class="mt-3 text-xs text-gray-400 flex flex-wrap gap-x-1">
        <span>Last update:</span>
        <span>{{ smartTimeFormat($tree['time']) }}</span>
    </div>
</div>
