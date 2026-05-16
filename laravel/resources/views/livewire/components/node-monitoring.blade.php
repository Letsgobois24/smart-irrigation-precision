<div>
    <h2 class="text-xl font-semibold text-green-700 mb-4">
        Monitoring Data Node
    </h2>

    <div class="bg-white shadow rounded-xl p-6 px-4 sm:px-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">

            <!-- Left -->
            <div class="flex items-center gap-3">
                <h3 class="text-lg font-bold text-green-800 flex items-center gap-2">
                    🌱 Node 1
                </h3>

                <!-- Status -->
                <div class="flex items-center gap-1 bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Online
                </div>
            </div>

            <!-- Right -->
            <div class="flex items-center gap-2">

                <!-- Refresh Monitoring -->
                <div class="flex items-center gap-1">
                    <button wire:click='refresh' wire:loading.attr='disabled' wire:loading.class='cursor-wait opacity-50'
                        wire:loading.remove.class='cursor-pointer'
                        class="hover:bg-gray-200 rounded-lg p-2 transition cursor-pointer flex items-center gap-x-2">

                        <x-icons.refresh size="22" wire:target='refresh' wire:loading.class='animate-spin' />
                        <span class="text-sm text-gray-500">Refresh</span>
                    </button>
                </div>

                <!-- Fetch Data -->
                <button wire:click="fetchNow" wire:loading.attr='disabled' wire:loading.class='cursor-wait opacity-50'
                    wire:loading.remove.class='cursor-pointer'
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow flex items-center gap-2 transition cursor-pointer">

                    <x-icons.refresh size="18" wire:loading.class="animate-spin" wire:target="fetchNow" />

                    Ambil Data
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <!-- 4 Tree -->
            @foreach ($node_data as $tree)
                <x-card.node :tree="$tree" />
            @endforeach
        </div>

        <div class="grid gap-6">
            <livewire:components.line-chart lazy field="soil_moisture" fieldName="Soil Moisture" table="node"
                groupby='tree_id' xlabel='Tree' ylabel='%' class="col-span-2" />
            <div class="bg-white rounded-2xl shadow p-4 sm:p-6 overflow-hidden">

                {{-- Header --}}
                <div class="flex flex-col mb-3">
                    <h2 class="text-lg font-bold text-gray-800">
                        🚨 System Event Monitoring
                    </h2>
                    <p class="text-sm text-gray-500">
                        Riwayat proses irigasi otomatis
                    </p>
                </div>

                {{-- Table --}}
                <livewire:components.system-event-table lazy />
            </div>
        </div>
    </div>
</div>
