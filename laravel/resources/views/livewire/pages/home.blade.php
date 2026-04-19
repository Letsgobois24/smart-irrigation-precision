<main class="bg-green-50 min-h-screen p-6">

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
                    <p class="text-xl font-bold text-green-700">120 L/min</p>
                </div>
            </div>

            <!-- Valve -->
            <div class="bg-white shadow rounded-xl p-4 flex items-center gap-3">
                <x-icons.valve-off size="32" class="mb-2" />

                <div>
                    <p class="text-gray-500 text-sm">Main Valve Status</p>
                    <span class="px-2 py-1 text-xs bg-green-200 text-green-800 rounded-full">
                        Aktif
                    </span>
                </div>
            </div>

            <!-- Update -->
            <div class="bg-white shadow rounded-xl p-4 flex items-center gap-3">
                <x-icons.clock size="32" class="text-gray-500" />
                <div>
                    <p class="text-gray-500 text-sm">Last Update</p>
                    <p class="text-sm font-semibold">18 Apr 2026</p>
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

    <!-- ================= NODE ================= -->
    <div>
        <h2 class="text-xl font-semibold text-green-700 mb-4">
            Monitoring Data Node
        </h2>

        <div class="bg-white shadow rounded-xl p-6">

            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-bold text-green-800 flex items-center gap-2">
                    🌱 Node 1
                </h3>
                <span class="text-sm text-gray-500">Last Update: 18 Apr 2026</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

                <!-- 4 Tree -->
                @foreach ($node_data as $tree)
                    <div class="bg-green-50 p-3 rounded-lg">
                        <div class="flex items-center gap-2 mb-1">
                            🌱 <p class="text-sm text-gray-500">Tree {{ $tree['tree_id'] }}</p>
                        </div>

                        <!-- Moisture -->
                        <div class="flex items-center gap-2">
                            <!-- icon kelembaban -->
                            <x-icons.humidity size="20" class="text-blue-500" />
                            <p class="font-bold">{{ $tree['soil_moisture'] }}%</p>
                        </div>

                        <!-- Valve -->
                        <div class="flex items-center gap-1 mt-1">
                            ⚙️
                            <p class="text-xs text-green-600">Valve {{ $tree['valve'] ? 'ON' : 'OFF' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border rounded-xl h-64 flex items-center justify-center">
                <p class="text-gray-400">📊 Grafik Kelembaban</p>
            </div>

        </div>
    </div>

</main>
