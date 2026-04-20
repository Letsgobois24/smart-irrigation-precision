<div>
    <h1 class="text-3xl font-bold text-green-800 mb-6 flex items-center gap-2">
        🌿 Dashboard Monitoring Irigasi
    </h1>

    <!-- ================= GLOBAL ================= -->
    <div class="mb-10">
        <h2 class="text-xl font-semibold text-green-700 mb-4">
            Monitoring Data Global
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <!-- PH -->
            <div class="bg-white shadow rounded-xl p-4 flex items-center gap-3">
                <!-- icon -->
                <x-icons.ph size="32" />
                <div>
                    <p class="text-gray-500 text-sm">pH</p>
                    <p class="text-xl font-bold text-green-700">6.8</p>
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
                <button wire:click='getDataNow' class="ml-auto cursor-pointer hover:bg-gray-200 rounded-lg p-1.5">
                    <x-icons.refresh size="28" wire:target='getDataNow' wire:loading.class='animate-spin' />
                </button>
            </div>

        </div>

        <!-- Charts -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-4 h-64 flex flex-col justify-center items-center">
                <p class="text-gray-400">📊 Grafik pH</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4 h-64 flex flex-col justify-center items-center">
                <p class="text-gray-400">💧 Grafik Debit Air</p>
            </div>
        </div>
    </div>
</div>
