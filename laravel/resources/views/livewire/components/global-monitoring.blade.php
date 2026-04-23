<div>
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-green-800 mb-6 flex items-center gap-2">
            🌿 Dashboard Monitoring Irigasi
        </h1>
        <div wire:ignore x-data="clock(@js($now))" x-init="init()" class="font-mono flex gap-x-2">
            <span x-text="time"></span>
            <span x-text="date"></span>
        </div>
    </div>

    <!-- ================= GLOBAL ================= -->
    <div class="mb-10">
        <h2 class="text-xl font-semibold text-green-700 mb-4">
            Monitoring Data Global
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">

            <!-- PH -->
            <div class="bg-white shadow rounded-xl p-4 flex items-center gap-3">
                <!-- icon -->
                <x-icons.ph size="32" />
                <div>
                    <p class="text-gray-500 text-sm">pH</p>
                    <p class="text-xl font-bold text-green-700">{{ $ph }}</p>
                </div>
            </div>

            <!-- Debit Air -->
            <div class="bg-white shadow rounded-xl p-4 flex items-center gap-3">
                <x-icons.water-flow size="24" class="text-blue-600" />
                <div>
                    <p class="text-gray-500 text-sm">Main Water Flow</p>
                    <p class="text-xl font-bold text-green-700">{{ $water_flow }} L/min</p>
                </div>
            </div>

            <!-- Valve -->
            <div class="bg-white shadow rounded-xl p-4 flex items-center gap-3">
                <x-icons.valve-off size="32" class="mb-2" />

                <div>
                    <p class="text-gray-500 text-sm">Main Valve Status</p>
                    <span class="px-2 py-1 text-xs bg-green-200 text-green-800 rounded-full">
                        {{ $main_valve ? '' : 'Non' }} Aktif
                    </span>
                </div>
            </div>

            <!-- Update -->
            <div class="bg-white shadow rounded-xl p-4 flex items-center gap-3">
                <x-icons.clock size="32" class="text-gray-500" />
                <div>
                    <p class="text-gray-500 text-sm">Last Update</p>
                    <p class="text-sm font-semibold">{{ $time->diffForHumans() }}</p>
                </div>
                <button wire:click='refresh' class="ml-auto cursor-pointer hover:bg-gray-200 rounded-lg p-1.5">
                    <x-icons.refresh size="28" wire:target='refresh' wire:loading.class='animate-spin' />
                </button>
            </div>

        </div>

        <!-- Charts -->
        <div class="grid md:grid-cols-2 gap-6">
            <livewire:components.line-chart lazy field="ph" fieldName="pH" table="environment" />
            <livewire:components.line-chart lazy field="water_flow" fieldName="Water Flow" table="environment" />
        </div>
    </div>
</div>
