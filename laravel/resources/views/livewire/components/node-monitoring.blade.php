<div>
    <h2 class="text-xl font-semibold text-green-700 mb-4">
        Monitoring Data Node
    </h2>

    <div class="bg-white shadow rounded-xl p-6 px-4 sm:px-6">

        <div class="flex flex-col sm:flex-row justify-between mb-4">
            <h3 class="text-lg font-bold text-green-800 flex items-center gap-2">
                🌱 Node 1
            </h3>
            <div class="flex flex-wrap justify-between sm:justify-start items-center gap-2">
                <div class="flex items-center gap-1">
                    {{-- Refresh button --}}
                    <button wire:click='refresh' wire:loading.attr='disabled' wire:loading.class='cursor-wait'
                        wire:loading.remove.class='cursor-pointer'
                        class="ml-auto cursor-pointer hover:bg-gray-200 rounded-lg p-1.5">
                        <x-icons.refresh size="24" wire:target='refresh' wire:loading.class='animate-spin' />
                    </button>
                    {{-- Last Update --}}
                    <span class="text-sm text-gray-500">Last Update: {{ $node_data[0]['time']->diffForHumans() }}</span>
                    {{-- Ambil data sekarang --}}
                </div>
                {{-- Refresh data --}}
                <button wire:click="fetchNow" wire:loading.attr='disabled'
                    wire:loading.class='cursor-not-allowed opacity-50' wire:loading.remove.class='cursor-pointer'
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg cursor-pointer text-sm shadow flex items-center gap-2">
                    <x-icons.refresh size="18" wire:loading.class="animate-spin" wire:target="fetchNow" />
                    Ambil Data
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">

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

        <div class="grid md:grid-cols-2 gap-6">
            <livewire:components.line-chart lazy field="soil_moisture" fieldName="Soil Moisture" table="node"
                groupby='tree_id' />
        </div>

    </div>
</div>
