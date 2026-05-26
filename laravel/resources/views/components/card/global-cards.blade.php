<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    <!-- PH -->
    <div
        class="rounded-2xl border shadow-sm p-4 transition
        {{ $ph_normal ? 'bg-emerald-50 border-emerald-100' : 'bg-red-50 border-red-100' }}">

        <div class="flex justify-between items-start mb-3">

            <div class="flex items-center gap-3">
                <div
                    class="p-2 rounded-xl
                    {{ $ph_normal ? 'bg-white text-emerald-600' : 'bg-white text-red-500' }}">
                    <x-icons.ph size="28" />
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        pH Air
                    </p>

                    <h3
                        class="text-2xl font-bold font-mono
                        {{ $ph_normal ? 'text-emerald-700' : 'text-red-600' }}">
                        {{ $ph }}
                    </h3>
                </div>
            </div>

            <x-ui.badge :color="$ph_normal ? 'emerald' : 'red'" size='md'>
                {{ $ph_normal ? 'Normal' : 'Tidak Normal' }}
            </x-ui.badge>
        </div>

        <p class="text-xs text-gray-600">
            {{ $ph_normal ? 'Kondisi pH optimal untuk irigasi.' : 'pH berada di luar batas ideal tanaman.' }}
        </p>
    </div>

    <!-- WATER FLOW -->
    <div
        class="rounded-2xl border shadow-sm p-4 transition
        {{ $flow_normal ? 'bg-sky-50 border-sky-100' : 'bg-yellow-50 border-yellow-100' }}">

        <div class="flex justify-between items-start mb-3">

            <div class="flex items-center gap-3">
                <div
                    class="p-2 rounded-xl bg-white
                    {{ $flow_normal ? 'text-blue-600' : 'text-yellow-600' }}">
                    <x-icons.water-flow size="24" />
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Water Flow
                    </p>

                    <h3
                        class="text-2xl font-bold
                        {{ $flow_normal ? 'text-blue-700' : 'text-yellow-700' }}">
                        <span class="font-mono">{{ $water_flow }}</span>
                        <span class="text-lg">L/min</span>
                    </h3>
                </div>
            </div>

            <x-ui.badge :color="$flow_normal ? 'blue' : 'yellow'" size='md'>
                {{ $flow_normal ? 'Flow' : 'Idle' }}
            </x-ui.badge>
        </div>

        <p class="text-xs text-gray-600">
            {{ $flow_normal ? 'Distribusi air berjalan normal.' : 'Tidak ada aliran air terdeteksi.' }}
        </p>
    </div>

    <!-- MAIN VALVE -->
    <div
        class="rounded-2xl border shadow-sm p-4 transition
        {{ $main_valve ? 'bg-emerald-50 border-emerald-100' : 'bg-gray-50 border-gray-200' }}">

        <div class="flex justify-between items-start mb-3">

            <div class="flex items-center gap-3">
                <div
                    class="p-2 rounded-xl
                    {{ $main_valve ? 'bg-white text-emerald-600' : 'bg-white text-gray-500' }}">
                    <x-icons.valve-off size="28" />
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Valve
                    </p>

                    <h3
                        class="text-xl font-bold
                        {{ $main_valve ? 'text-emerald-700' : 'text-gray-700' }}">

                        {{ $main_valve ? 'Aktif' : 'Non Aktif' }}
                    </h3>
                </div>
            </div>

            <x-ui.badge :color="$main_valve ? 'emerald' : 'gray'" size='md'>
                {{ $main_valve ? 'ON' : 'OFF' }}
            </x-ui.badge>
        </div>

        <p class="text-xs text-gray-600">
            {{ $main_valve ? 'Katup utama sedang membuka aliran.' : 'Katup utama sedang tertutup.' }}
        </p>
    </div>

    <!-- LAST UPDATE -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-4">

        <div class="flex justify-between items-start mb-3">

            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-gray-100 text-gray-600">
                    <x-icons.clock size="26" />
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Last Update
                    </p>

                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $time->diffForHumans() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 text-xs text-gray-500">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            Sistem monitoring aktif
        </div>
    </div>

</div>
