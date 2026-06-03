<main class="bg-green-50 min-h-screen p-6 px-2 sm:px-6 w-full">
    <div class="mb-10">
        {{-- Global Header --}}
        <x-header.monitoring-header icon='🌏' title="Global Monitoring"
            description='Ringkasan kondisi utama sistem smart irrigation precision' />

        <x-card.global-cards :global-data="$data" />

        <!-- Charts -->
        <div class="grid md:grid-cols-2 gap-6">
            <livewire:components.line-chart lazy field="ph" fieldName="pH" table="global" />
            <livewire:components.line-chart lazy field="water_flow" fieldName="Water Flow" table="global"
                ylabel=' L/m' />
            <x-container title="Global Periodic Table" description='Riwayat data global secara periodik'
                class="col-span-full">
                <livewire:components.global-table lazy />
            </x-container>
        </div>

    </div>
</main>
