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
        <div class="bg-white shadow rounded-xl p-6 px-4 sm:px-6 col-span-full">
            {{-- Header --}}
            <div class="flex flex-col mb-3">
                <h2 class="text-lg font-bold text-gray-800">
                    Global Periodic Table
                </h2>
                <p class="text-sm text-gray-500">
                    Riwayat data global secara periodik
                </p>
            </div>
            <livewire:components.global-table lazy />
        </div>
    </div>

</div>
