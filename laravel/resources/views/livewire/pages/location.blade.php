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
                <div class="w-4 h-4 rounded bg-gray-400"></div>
                <span>Non Active</span>
            </div>

        </div>
    </div>

    <!-- Heatmap Grid -->
    <div dir="rtl" class="grid gap-4" style="grid-template-columns: repeat({{ $max_col }}, minmax(0, 1fr))">
        @foreach ($trees as $tree)
            <button
                class="{{ $tree['is_active'] ? 'bg-emerald-500' : 'bg-gray-400' }}
            relative rounded-2xl py-4 px-5 text-white
            shadow-md hover:scale-105
            transition-all duration-200">

                <!-- HEADER -->
                <div class="flex items-center justify-between">
                    <span class="text-[13px] font-semibold opacity-80 m-1.5">
                        {{ chr(64 + $tree['row_idx']) . $tree['col_idx'] }}
                    </span>

                    <span class="flex justify-center items-center text-sm font-medium bg-white/20 size-6 rounded-full">
                        {{ $tree['tree_id'] }}
                    </span>
                </div>

                @if ($tree['is_active'])
                    <!-- ACTIVE CONTENT -->
                    <div class="mt-6">
                        <h2 class="text-3xl font-bold">
                            {{ $tree['soil_moisture'] }}%
                        </h2>

                        <p class="text-sm opacity-90">
                            Soil Moisture
                        </p>
                    </div>

                    <!-- Anomaly Count -->
                    <div class="mt-4 text-xs opacity-80">
                        Anomaly Detected: {{ $tree['notifications_count'] }}
                    </div>

                    <!-- FOOTER -->
                    <div class="text-xs opacity-80">
                        Last update:
                        {{ $tree['time'] ? smartTimeFormat($tree['time']) : '-' }}
                    </div>
                @else
                    <!-- INACTIVE CONTENT -->
                    <div class="flex flex-col items-center justify-center">
                        <x-icons.wifi-off size='36' class="mt-4" />
                        <h2 class="text-lg font-semibold">
                            Tree Inactive
                        </h2>
                        <p class="mt-4 text-sm opacity-80">
                            Pohon tidak terhubung sistem monitoring
                        </p>
                    </div>
                @endif

            </button>
        @endforeach

    </div>

</div>
