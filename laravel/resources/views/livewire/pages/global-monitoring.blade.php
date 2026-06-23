<main>
    {{-- Global Header --}}
    <x-header.monitoring-header icon='🌏' title="Global Monitoring"
        description='Ringkasan kondisi utama sistem smart irrigation precision' />

    <x-card.global-cards :global-data="$data" />

    <!-- Global Data Visualization -->
    <div class="grid md:grid-cols-2 gap-6 mb-6">
        {{-- pH Chart --}}
        <livewire:components.line-chart :key="'ph-chart' . $refresh_child" lazy field="ph" fieldName="pH" table="global" />
        {{-- Water Flow Chart --}}
        <livewire:components.line-chart :key="'water-flow-chart' . $refresh_child" lazy field="water_flow" fieldName="Water Flow" table="global"
            ylabel=' L/m' />
        {{-- Light Intensity Chart --}}
        <livewire:components.line-chart :key="'light-chart' . $refresh_child" lazy field="light" fieldName="Light Intensity" table="global"
            ylabel='' />
        {{-- Table --}}
        <x-container title="Global Periodic Table" description='Riwayat data global secara periodik'>
            <livewire:components.global-table :key="'global-table' . $refresh_child" lazy />
        </x-container>
    </div>

</main>
