@props(['tree'])

<div class="bg-green-50 p-3 rounded-lg">
    <div class="flex items-center gap-2 mb-1">
        🌱 <p class="text-sm text-gray-500">Tree {{ $tree['tree_id'] }}</p>
    </div>

    <!-- Moisture -->
    <div class="flex items-center gap-2">
        <!-- icon kelembaban -->
        <x-icons.humidity size="20" class="text-blue-500" />
        <p class="font-bold">{{ $tree['soil_moisture'] }}%</p>
    </div>

    <!-- Valve -->
    <div class="flex items-center gap-1 mt-1">
        ⚙️
        <p class="text-xs text-green-600">Valve {{ $tree['valve'] ? 'ON' : 'OFF' }}</p>
    </div>

    <!-- Detail Update -->
    <div class="mt-2 text-xs text-gray-400 flex flex-wrap gap-x-1">
        <span>Last update:</span>
        <span>{{ smartTimeFormat($tree['time']) }}</span>
    </div>
</div>
