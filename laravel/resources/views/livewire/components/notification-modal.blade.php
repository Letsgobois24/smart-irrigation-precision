<div x-data="{ isOpenNotification: false, view: 'list' }" @filter-location.window="isOpenNotification = true; $wire.openNotification();">
    <!-- BUTTON -->
    <button wire:click='openNotification' @click="isOpenNotification = true; view='list'"
        class="flex relative cursor-pointer ml-3 mr-7 size-10 justify-center items-center rounded-full hover:bg-green-50/30">

        @if ($total_active > 0)
            <div
                class="absolute top-0.5 right-1 bg-orange-500 size-4.5 rounded-full flex justify-center items-center text-xs">
                {{ $total_active }}
            </div>
        @endif

        <x-icons.bell size='30' class="text-gray-100" />
    </button>

    <!-- MODAL -->
    <div x-show="isOpenNotification" x-cloak x-transition.opacity.duration.200ms
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

        <div @click.outside="isOpenNotification = false"
            class="bg-white w-full max-w-5xl h-[90vh] md:h-[80vh] rounded-2xl shadow-xl flex flex-col md:flex-row overflow-hidden">

            {{-- FIRST LOADING --}}
            @if (!$isNotificationLoaded)
                <div class="w-full h-full flex items-center justify-center">
                    <x-icons.loading size="48" class="animate-spin text-gray-500" />
                </div>
            @else
                <!-- LEFT -->
                <div x-data="{ dateInput: null }" class="relative w-full md:w-1/3 border-r overflow-y-auto"
                    x-show="view === 'list' || window.innerWidth >= 768">

                    <!-- FILTER LOADING OVERLAY -->
                    <div wire:loading.flex wire:target="setSeverity,setStatus,setDateRange,setLocation,resetFilter"
                        class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-20 items-center justify-center">

                        <x-icons.loading size="28" class="animate-spin text-gray-500" />
                    </div>

                    <!-- HEADER -->
                    <div class="p-4 pb-2 border-b space-y-3">

                        <div class="flex justify-between items-center">
                            <div class="flex gap-x-2 items-center">
                                <x-icons.bell size='22' class="text-yellow-500" />
                                <h2 class="font-semibold">
                                    Notifikasi
                                </h2>
                            </div>

                            <button @click="isOpenNotification = false"
                                class="rounded-md p-1 text-gray-700 hover:bg-gray-50 cursor-pointer">
                                <x-icons.cross size="20" />
                            </button>
                        </div>

                        <!-- FILTER -->
                        @php
                            function activeBadge(bool $is_active)
                            {
                                if ($is_active) {
                                    return 'scale-105 ring-1 ring-offset-1 shadow-sm';
                                }
                                return 'opacity-70 hover:opacity-100 hover:scale-105';
                            }
                        @endphp
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-y-2 gap-x-3">
                            <!-- Severity -->
                            <div class="md:col-span-full">
                                <label class="text-[13px] font-medium mb-2 ml-1">
                                    Severity
                                </label>

                                <div class="flex flex-wrap gap-2">
                                    @foreach ($severities as $key => $severity)
                                        <x-ui.badge wire:click="setSeverity('{{ $key }}')" :color="$severity['color']"
                                            size='sm'
                                            class="cursor-pointer transition-all duration-200 {{ activeBadge($key == $selected_severity) }}">

                                            {{ $severity['name'] }}
                                        </x-ui.badge>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="md:col-span-full">
                                <label class="text-[13px] font-medium mb-2 ml-1">
                                    Status
                                </label>

                                <div class="flex flex-wrap gap-2">
                                    @foreach ($statuses as $key => $status)
                                        <x-ui.badge :color="$status['color']" wire:click="setStatus('{{ $key }}')"
                                            size='sm'
                                            class="cursor-pointer transition-all duration-200 {{ activeBadge($key == $selected_status) }}">

                                            {{ $status['name'] }}
                                        </x-ui.badge>
                                    @endforeach
                                </div>
                            </div>

                            <!-- DATE -->
                            <div class="md:col-span-3">
                                <label class="text-[13px] font-medium mb-2 ml-1.5">
                                    Date
                                </label>

                                <x-form.date-range :date_range="$date_range" width='full' placeholder='Select Date' />
                            </div>

                            <!-- LOCATION -->
                            <div class="md:col-span-2">
                                <label class="text-[13px] font-medium mb-2 ml-1.5">
                                    Location
                                </label>

                                <x-form.select wire:change='setLocation' model="selected_location" :data="$locations"
                                    disabled_option='Select Location' />
                            </div>
                            <span class="col-span-full text-center text-[13px] text-gray-500">
                                {{ $total_result ? "Showing $total_result results" : 'No results found' }}
                            </span>
                        </div>
                    </div>

                    <!-- LIST -->
                    @if (count($notifications) == 0)
                        <div class="flex flex-col items-center justify-center text-center px-6 py-14">

                            <x-icons.bell-off size="42" class="text-gray-300 mb-3" />

                            <h3 class="font-medium text-gray-700">
                                Notifikasi tidak ditemukan
                            </h3>

                            <p class="text-sm text-gray-500 mt-1 max-w-xs">
                                Coba ubah filter severity, status, tanggal, atau lokasi.
                            </p>

                            <!-- RESET FILTER -->
                            <button wire:click="resetFilter" @click='dateInput.clear()'
                                class="mt-4 px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm text-gray-700 transition cursor-pointer">

                                Reset Filter
                            </button>
                        </div>
                    @else
                        @foreach ($notifications as $notification)
                            @php
                                $config_class = $this->getConfigClass($notification['severity']);
                            @endphp

                            <div wire:click="detailNotification(@js($notification['id']))" @click="view='detail'"
                                class="p-4 cursor-pointer border-b transition-colors duration-200"
                                :class="@js($active_notification['id'] === $notification['id'])
                                    ?
                                    'bg-gray-100' :
                                    'hover:bg-gray-50'">

                                <div class="flex items-center gap-x-1">

                                    <h5 class="text-sm font-semibold {{ $config_class['text'] }}">
                                        {{ $notification['rule']['title'] }}
                                    </h5>

                                    <div class="flex-1">
                                        @if ($notification['is_active'])
                                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full block"></span>
                                        @endif
                                    </div>

                                    <x-ui.badge class="capitalize" size='sm' :color="$config_class['badge']">
                                        {{ $notification['severity'] }}
                                    </x-ui.badge>
                                </div>

                                <div class="text-xs text-gray-500">
                                    Tree {{ $notification['tree_id'] }}
                                    •
                                    {{ $notification['created_at'] }}
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- LOAD MORE -->
                    @if (!$isMaxLoaded && $notifications)
                        <div x-intersect="$wire.loadMore()" class="h-6"></div>
                    @endif

                    <!-- LOADING MORE -->
                    <div wire:loading.flex wire:target='loadMore' class="w-full h-16 items-center justify-center">
                        <x-icons.loading size="24" class="animate-spin text-gray-500" />
                    </div>
                </div>

                <!-- RIGHT DETAIL -->
                <div class="relative flex-1 h-full" x-show="view === 'detail' || window.innerWidth >= 768">

                    <!-- DETAIL OVERLAY -->
                    <div wire:loading.flex wire:target="detailNotification"
                        class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-20 flex items-center justify-center">
                        <x-icons.loading size="36" class="animate-spin text-gray-500" />
                    </div>

                    <!-- BACK -->
                    <button @click="view='list'" class="mb-3 text-sm text-gray-600 md:hidden cursor-pointer group">
                        <span class="inline-block group-hover:-translate-x-1 transition">
                            ←
                        </span>
                        Kembali
                    </button>

                    @if (!$active_notification)
                        <div class="h-full flex flex-col items-center justify-center text-center px-6">

                            <x-icons.bell-off size="52" class="text-gray-300 mb-4" />

                            <h3 class="text-lg font-semibold text-gray-700">
                                Belum ada notifikasi dipilih
                            </h3>

                            <p class="text-sm text-gray-500 mt-1 max-w-sm">
                                Pilih salah satu notifikasi pada panel kiri untuk melihat detail.
                            </p>
                        </div>
                    @else
                        @php
                            $config_class = $this->getConfigClass($active_notification['severity']);
                        @endphp

                        <div class="h-full overflow-y-auto p-4 md:p-6 space-y-5">

                            <!-- HEADER -->
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">

                                <div class="flex items-center gap-2">

                                    <h5 class="text-lg font-semibold {{ $config_class['text'] }}">
                                        {{ $active_notification['rule']['title'] }}
                                    </h5>

                                    <x-ui.badge class="capitalize" size="md" :color="$config_class['badge']">
                                        {{ $active_notification['severity'] }}
                                    </x-ui.badge>

                                </div>

                                <span class="text-xs text-gray-500">
                                    {{ smartTimeFormat(new \Carbon\Carbon($active_notification['created_at'])) }}
                                </span>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="bg-blue-50 border border-blue-100 p-4 rounded-lg">
                                <h6 class="font-semibold text-blue-700 mb-1">
                                    Deskripsi
                                </h6>

                                <p class="text-sm text-blue-900">
                                    {{ $active_notification['rule']['description'] }}
                                </p>
                            </div>

                            <!-- DIAGNOSIS -->
                            <div class="bg-gray-50 rounded-xl p-5">

                                <h6 class="font-semibold text-gray-800 mb-4">
                                    Informasi Diagnosis
                                </h6>

                                <!-- Lokasi Diagnosis -->
                                <div class="grid grid-cols-2 gap-4 mb-4">


                                    <div class="bg-white rounded-lg border p-4">
                                        <div class="text-xs text-gray-500">
                                            Node (Area) Diagnosis
                                        </div>

                                        <div class="text-2xl font-bold text-purple-600">
                                            {{ $active_notification['node_id'] }}
                                        </div>

                                        <div class="text-xs text-gray-500 mt-1">
                                            Menunjukkan kelompok sistem yang terindikasi mengalami gangguan.
                                        </div>
                                    </div>

                                    <div class="bg-white rounded-lg border p-4">
                                        <div class="text-xs text-gray-500">
                                            Pohon (Tree) Diagnosis
                                        </div>

                                        <div class="text-2xl font-bold text-green-600">
                                            {{ $active_notification['tree_id'] }}
                                        </div>

                                        <div class="text-xs text-gray-500 mt-1">
                                            Menunjukkan lokasi diagnosis yang lebih spesifik pada pohon terpilih.
                                        </div>
                                    </div>

                                </div>

                                <!-- Tingkat Anomali -->
                                <div class="bg-white rounded-lg border p-4 mb-4">

                                    <div class="flex items-center justify-between">

                                        <div>
                                            <div class="text-sm text-gray-500">
                                                Keparahan Gangguan
                                            </div>

                                            <div class="mt-1">
                                                <x-ui.badge size="sm" :color="$config_class['badge']">
                                                    {{ ucfirst($active_notification['severity']) }}
                                                </x-ui.badge>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <div class="text-3xl font-bold {{ $config_class['text'] }}">
                                                {{ number_format($active_notification['fault_ratio'], 2) }}
                                            </div>

                                            <div class="text-xs text-gray-500">
                                                Skor Gangguan
                                            </div>
                                        </div>

                                    </div>

                                    <div class="text-xs text-gray-500 mt-3">
                                        Semakin tinggi skor gangguan, semakin besar penyimpangan dari kondisi normal.
                                    </div>

                                </div>

                                <!-- Parameter Utama -->
                                <div class="bg-white rounded-lg border p-4">

                                    <div class="text-sm text-gray-500">
                                        Parameter Utama Penyebab Gangguan
                                    </div>

                                    <div class="mt-1 text-lg font-semibold text-gray-800">
                                        {{ $active_notification['rule']['title'] }}
                                    </div>

                                    <div class="mt-3 flex items-center justify-between">

                                        <span class="text-sm text-gray-600">
                                            Kontribusi terhadap total gangguan
                                        </span>

                                        <span class="font-bold text-orange-500">
                                            {{ number_format($active_notification['dominant_ratio'] * 100, 1) }}%
                                        </span>

                                    </div>

                                    <div class="mt-2 text-xs text-gray-500">
                                        Parameter ini memberikan kontribusi terbesar terhadap gangguan yang terdeteksi.
                                    </div>

                                </div>

                            </div>

                            <!-- POSSIBLE PROBLEMS -->
                            <div class="bg-red-50 p-4 rounded-lg">

                                <h6 class="font-semibold text-red-700 mb-2">
                                    Kemungkinan Penyebab
                                </h6>

                                <ul class="list-disc ml-5 text-sm text-red-800 space-y-1">
                                    @foreach (json_decode($active_notification['rule']['problem']) as $problem)
                                        <li>{{ $problem }}</li>
                                    @endforeach
                                </ul>

                            </div>

                            <!-- RECOMMENDATION -->
                            <div class="bg-green-50 p-4 rounded-lg">

                                <h6 class="font-semibold text-green-700 mb-2">
                                    Rekomendasi Tindakan
                                </h6>

                                <ul class="list-disc ml-5 text-sm text-green-800 space-y-1">
                                    @foreach (json_decode($active_notification['rule']['recommendation']) as $recommendation)
                                        <li>{{ $recommendation }}</li>
                                    @endforeach
                                </ul>

                            </div>

                            <!-- ACTION -->
                            <button wire:click="resolve" wire:loading.attr="disabled"
                                wire:loading.class="cursor-wait opacity-50"
                                class="w-full md:w-auto px-4 py-2 rounded-lg transition-all duration-200 cursor-pointer
                    {{ $active_notification['is_active']
                        ? 'bg-blue-600 hover:bg-blue-700 text-white'
                        : 'bg-gray-200 hover:bg-gray-300 text-gray-700' }}">

                                {{ $active_notification['is_active'] ? 'Tandai Terselesaikan' : 'Batalkan Penyelesaian' }}
                            </button>

                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
