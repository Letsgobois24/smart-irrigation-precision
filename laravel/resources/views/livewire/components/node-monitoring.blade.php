<div>
    <h2 class="text-xl font-semibold text-green-700 mb-4">
        Monitoring Data Node
    </h2>

    <div class="bg-white shadow rounded-xl p-6">

        <div class="flex justify-between mb-4">
            <h3 class="text-lg font-bold text-green-800 flex items-center gap-2">
                🌱 Node 1
            </h3>
            <div class="flex items-center gap-x-2">
                <span class="text-sm text-gray-500">Last Update: {{ $node_data[0]['time']->diffForHumans() }}</span>
                <button wire:click='getDataNow' class="ml-auto cursor-pointer hover:bg-gray-200 rounded-lg p-1.5">
                    <x-icons.refresh size="24" wire:target='getDataNow' wire:loading.class='animate-spin' />
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

            <!-- 4 Tree -->
            @foreach ($node_data as $tree)
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
                </div>
            @endforeach
        </div>

        <div class="border rounded-xl h-64 flex items-center justify-center">
            <p class="text-gray-400">📊 Grafik Kelembaban</p>
        </div>

    </div>
</div>
