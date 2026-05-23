<div class="bg-green-50 min-h-screen p-6 px-2 sm:px-6 w-full space-y-6">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-emerald-700">
                Smart Irrigation Heatmap
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Monitoring kondisi area pohon berdasarkan grid
            </p>
        </div>

        <!-- Legend -->
        <div class="flex flex-wrap items-center gap-3 text-sm">

            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-emerald-500"></div>
                <span>Active</span>
            </div>

            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-gray-300"></div>
                <span>Non Active</span>
            </div>

        </div>
    </div>

    <!-- Heatmap Grid -->
    <div class="grid grid-cols-4 gap-4">

        @foreach ($trees as $tree)
            @php
                $bgColor = match ($tree['is_active']) {
                    1 => 'bg-emerald-500',
                    default => 'bg-gray-300',
                };
            @endphp

            <button
                class="{{ $bgColor }}
                    relative rounded-2xl p-4 text-white
                    shadow-md hover:scale-105
                    transition-all duration-200">

                <!-- Grid -->
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium opacity-80">
                        {{ chr(64 + $tree['row_idx']) . $tree['col_idx'] }}
                    </span>

                    <span class="text-[10px] bg-white/20 px-2 py-1 rounded-full">
                        {{ $tree['tree_id'] }}
                    </span>
                </div>

                <!-- Moisture -->
                <div class="mt-6">
                    <h2 class="text-3xl font-bold">
                        {{ $tree['soil_moisture'] }}%
                    </h2>

                    <p class="text-sm opacity-90">
                        Soil Moisture
                    </p>
                </div>

                <!-- Footer -->
                <div class="mt-4 text-xs opacity-80">
                    Last update:
                    {{ $tree['time'] ? smartTimeFormat($tree['time']) : '-' }}
                </div>

            </button>
        @endforeach

    </div>

</div>
