<div>
    <h2 class="text-xl font-semibold text-green-700 mb-4">
        Monitoring Data Node
    </h2>

    {{-- Node Header --}}
    <div class="bg-white shadow rounded-xl p-6 px-4 sm:px-6">
        <x-header.monitoring-header icon='🌱' title="Node 1"
            description='Ringkasan kondisi beberapa pohon dari node 1'>
            <x-slot:badge>
                <div
                    class="flex items-center gap-1 bg-emerald-100 text-emerald-700 text-xs font-medium px-2.5 py-1 rounded-full border border-emerald-200">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    Online
                </div>
            </x-slot:badge>
        </x-header.monitoring-header>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <!-- 4 Trees -->
            @foreach ($node_data as $tree)
                <x-card.tree-card :tree="$tree" />
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
