<main>
    {{-- Node Monitoring Header --}}
    <x-header.monitoring-header icon='🌱' title="Node 1" description='Ringkasan kondisi beberapa pohon dari node 1'>
        <x-slot:badge>
            <x-ui.badge size='sm' color='emerald' class="flex items-center gap-1 border border-emerald-200">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Online
            </x-ui.badge>
        </x-slot:badge>
    </x-header.monitoring-header>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <!-- New 4 Trees Data -->
        @foreach ($node_data as $tree)
            <x-card.tree-card :tree="$tree" />
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Soil Moisture Chart --}}
        <livewire:components.line-chart lazy field="soil_moisture" fieldName="Soil Moisture" table="node"
            groupby='tree_id' xlabel='Tree' ylabel='%' class="col-span-2" />
        {{-- Node Monitoring --}}
        <x-container title="Tree Table" description='Riwayat data pohon'>
            <livewire:components.node-table lazy />
        </x-container>
    </div>

</main>
