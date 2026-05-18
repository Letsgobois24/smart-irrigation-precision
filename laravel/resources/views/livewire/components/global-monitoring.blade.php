<!-- ================= GLOBAL ================= -->
<div class="mb-10">
    {{-- Global Header --}}
    <x-header.monitoring-header icon='🌏' title="Global Monitoring"
        description='Ringkasan kondisi utama sistem smart irrigation precision' />

    <x-card.global-cards :global-data="$data" />

    <!-- Charts -->
    <div class="grid md:grid-cols-2 gap-6">
        <livewire:components.line-chart lazy field="ph" fieldName="pH" table="global" />
        <livewire:components.line-chart lazy field="water_flow" fieldName="Water Flow" table="global" ylabel=' L/m' />
    </div>
</div>
