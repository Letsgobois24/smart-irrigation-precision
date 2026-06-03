<main class="bg-green-50 min-h-screen p-6 px-2 sm:px-6 w-full">
    <div class="mb-10">
        {{-- Global Header --}}
        <x-header.monitoring-header icon='🌏' title="Global Monitoring"
            description='Ringkasan kondisi utama sistem smart irrigation precision' />

        <x-card.global-cards :global-data="$data" />

        <!-- Global Data Visualization -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            {{-- pH Chart --}}
            <livewire:components.line-chart lazy field="ph" fieldName="pH" table="global" />
            {{-- Water Flow Chart --}}
            <livewire:components.line-chart lazy field="water_flow" fieldName="Water Flow" table="global"
                ylabel=' L/m' />
            {{-- Water Flow Chart --}}
            <livewire:components.line-chart lazy field="light" fieldName="Light Intensity" table="global"
                ylabel='' />
            {{-- Table --}}
            <x-container title="Global Periodic Table" description='Riwayat data global secara periodik'>
                <livewire:components.global-table lazy />
            </x-container>
        </div>

    </div>
</main>
