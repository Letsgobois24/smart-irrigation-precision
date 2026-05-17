<div>
    <h2 class="text-xl font-semibold text-green-700 mb-4">
        Monitoring Data Node
    </h2>

    <div class="bg-white shadow rounded-xl p-6 px-4 sm:px-6">

        <div
            class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-5 bg-white rounded-2xl border border-green-100 shadow-sm px-5 py-4">

            <!-- LEFT -->
            <div class="flex items-center justify-between gap-4">

                <div class="flex items-center gap-3">

                    <!-- Node Icon -->
                    <div
                        class="w-11 h-11 rounded-xl bg-linear-to-br from-green-500 to-emerald-600 text-white flex items-center justify-center shadow-md">
                        🌱
                    </div>

                    <!-- Node Info -->
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-gray-800">
                                Node 1
                            </h3>

                            <!-- Live Badge -->
                            <div
                                class="flex items-center gap-1 bg-emerald-100 text-emerald-700 text-xs font-medium px-2.5 py-1 rounded-full border border-emerald-200">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                Online
                            </div>
                        </div>

                        <p class="text-sm text-gray-500">
                            Smart Irrigation Monitoring
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">

                <!-- Refresh -->
                <button wire:click="refresh" wire:loading.attr="disabled" wire:target="refresh"
                    class="group flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm cursor-pointer">

                    <div
                        class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition">
                        <x-icons.refresh size="18" wire:loading.class="animate-spin" wire:target="refresh"
                            class="text-gray-600" />
                    </div>

                    <div class="text-left">
                        <p class="text-sm font-semibold text-gray-700">
                            Refresh
                        </p>
                        <p class="text-[11px] text-gray-400">
                            Update monitoring
                        </p>
                    </div>
                </button>

                <!-- Fetch Data -->
                <button wire:click="fetchNow" wire:loading.attr="disabled" wire:target="fetchNow"
                    class="group relative overflow-hidden flex items-center gap-3 px-5 py-2.5 rounded-xl
                        bg-linear-to-r from-emerald-600 to-green-700
                        hover:from-emerald-700 hover:to-green-800
                        text-white shadow-lg shadow-green-200
                        transition-all duration-200 cursor-pointer">

                    <!-- Glow -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition bg-white/10">
                    </div>

                    <!-- Icon -->
                    <div class="relative w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                        <x-icons.refresh size="18" wire:loading.class="animate-spin" wire:target="fetchNow" />
                    </div>

                    <!-- Text -->
                    <div class="relative text-left">
                        <p class="text-sm font-semibold">
                            Ambil Data
                        </p>
                        <p class="text-[11px] text-green-100">
                            Request sensor terbaru
                        </p>
                    </div>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">

            <!-- 4 Tree -->
            @foreach ($node_data as $tree)
                <x-card.tree-card :tree="$tree" />
            @endforeach
        </div>

        <div class="grid gap-6">
            <livewire:components.line-chart lazy field="soil_moisture" fieldName="Soil Moisture" table="node"
                groupby='tree_id' xlabel='Tree' ylabel='%' class="col-span-2" />
            <div class="bg-white rounded-2xl shadow p-4 sm:p-6 overflow-hidden">

                {{-- Header --}}
                <div class="flex flex-col mb-3">
                    <h2 class="text-lg font-bold text-gray-800">
                        🚨 System Event Monitoring
                    </h2>
                    <p class="text-sm text-gray-500">
                        Riwayat proses irigasi otomatis
                    </p>
                </div>

                {{-- Table --}}
                <livewire:components.system-event-table lazy />
            </div>
        </div>
    </div>
</div>
