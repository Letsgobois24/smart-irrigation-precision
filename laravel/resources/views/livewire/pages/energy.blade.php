<main class="space-y-8">
    <section>
        <h1 class="mb-2 text-2xl font-bold">Energy Monitoring</h1>
        <x-card.energy-cards :energy-data="$energy_data" />
    </section>

    {{-- Energy Table --}}
    <x-container title="Energy Table" description='displays the energy data in a tabular format'>
        <livewire:components.energy-table :key="'energy-table' . $refresh_child" />
    </x-container>

    {{-- ================= BATTERY ================= --}}
    <section class="bg-white rounded-2xl shadow-sm border border-emerald-200 overflow-hidden">

        <div class="flex items-center gap-3 px-6 py-4 bg-emerald-50 border-b border-emerald-200">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center">
                🔋
            </div>

            <div>
                <h2 class="text-lg font-bold text-gray-800">
                    Battery Monitoring
                </h2>
                <p class="text-sm text-gray-500">
                    Battery SOC and Voltage
                </p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 p-6">

            <livewire:components.line-chart :key="'battery-soc' . $refresh_child" lazy field="battery_soc" fieldName="Battery SOC"
                table="energy" ylabel="%" />

            <livewire:components.line-chart :key="'battery-voltage' . $refresh_child" lazy field="battery_voltage" fieldName="Battery Voltage"
                table="energy" ylabel="V" />

        </div>

    </section>

    {{-- ================= LOAD ================= --}}
    <section class="bg-white rounded-2xl shadow-sm border border-blue-200 overflow-hidden">

        <div class="flex items-center gap-3 px-6 py-4 bg-blue-50 border-b border-blue-200">
            <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center">
                ⚡
            </div>

            <div>
                <h2 class="text-lg font-bold text-gray-800">
                    Load Monitoring
                </h2>
                <p class="text-sm text-gray-500">
                    Load Current and Power
                </p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 p-6">

            <livewire:components.line-chart :key="'load-current' . $refresh_child" lazy field="load_current" fieldName="Load Current"
                table="energy" ylabel="A" />

            <livewire:components.line-chart :key="'load-power' . $refresh_child" lazy field="load_power" fieldName="Load Power"
                table="energy" ylabel="W" />

        </div>

    </section>

    {{-- ================= PV ================= --}}
    <section class="bg-white rounded-2xl shadow-sm border border-amber-200 overflow-hidden">

        <div class="flex items-center gap-3 px-6 py-4 bg-amber-50 border-b border-amber-200">
            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center">
                ☀️
            </div>

            <div>
                <h2 class="text-lg font-bold text-gray-800">
                    Solar PV Monitoring
                </h2>
                <p class="text-sm text-gray-500">
                    PV Voltage, Current and Power
                </p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 p-6">

            <livewire:components.line-chart :key="'pv-voltage' . $refresh_child" lazy field="pv_voltage" fieldName="PV Voltage"
                table="energy" ylabel="V" />

            <livewire:components.line-chart :key="'pv-current' . $refresh_child" lazy field="pv_current" fieldName="PV Current"
                table="energy" ylabel="A" />

            <div class="lg:col-span-2">
                <livewire:components.line-chart :key="'pv-power' . $refresh_child" lazy field="pv_power" fieldName="PV Power"
                    table="energy" ylabel="W" />
            </div>

        </div>

    </section>

</main>
