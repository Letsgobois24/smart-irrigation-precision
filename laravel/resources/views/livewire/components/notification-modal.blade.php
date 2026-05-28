<div x-data="{ isOpenNotification: false, view: 'list' }">
    <!-- BUTTON -->
    <button wire:click='openNotification' @click="isOpenNotification = true; view='list'"
        class="flex relative cursor-pointer ml-3 mr-7 size-10 justify-center items-center rounded-full hover:bg-green-50/30">

        @if ($count_notifications > 0)
            <div
                class="absolute top-0.5 right-1 bg-orange-500 size-4 rounded-full flex justify-center items-center text-xs">
                {{ $count_notifications }}
            </div>
        @endif

        <x-icons.bell size='30' class="text-gray-100" />
    </button>

    <!-- MODAL -->
    <div x-show="isOpenNotification" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

        <div @click.outside="isOpenNotification = false"
            class="bg-white w-full max-w-5xl h-[90vh] md:h-[80vh] rounded-2xl shadow-xl flex flex-col md:flex-row overflow-hidden">

            @if (!$isNotificationLoaded)
                <div class="w-full h-full">
                    <x-icons.loading size="48" class="m-auto h-full" />
                </div>
            @elseif(count($notifications) == 0)
                <div class="w-full h-full flex flex-col items-center justify-center text-center px-4">
                    <x-icons.bell-off size="48" class="text-gray-400 mb-3" />

                    <h3 class="text font-semibold text-gray-700">
                        Tidak ada notifikasi
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Semua notifikasi akan muncul di sini
                    </p>
                    <button @click="isOpenNotification = false"
                        class="mt-3 text-sm text-blue-600 hover:underline cursor-pointer">
                        Tutup
                    </button>
                </div>
            @else
                <!-- LEFT: LIST -->
                <div class="w-full md:w-1/3 border-r overflow-y-auto"
                    x-show="view === 'list' || window.innerWidth >= 768">
                    <!-- HEADER -->
                    <div class="p-4 border-b space-y-3">

                        <div class="flex justify-between items-center">
                            <div class="flex gap-x-2 items-center">
                                <x-icons.bell size='22' class="text-yellow-500" />
                                <h2 class="font-semibold">Notifikasi</h2>
                            </div>

                            <!-- CLOSE -->
                            <button @click="isOpenNotification = false"
                                class="rounded-md p-1 text-gray-700 hover:bg-gray-50 cursor-pointer">
                                <x-icons.cross size="20" />
                            </button>
                        </div>

                        <!-- FILTER -->
                        <div class="space-y-2">
                            <!-- Severity Select -->
                            @php
                                function activeBadge(bool $is_active)
                                {
                                    if ($is_active) {
                                        return 'scale-105 ring-1 ring-offset-1 shadow-sm';
                                    }
                                    return 'opacity-70 hover:opacity-100 hover:scale-105';
                                }
                            @endphp

                            <div>
                                <label class="text-[13px] font-medium mb-2 ml-1">Severity</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($severities as $key => $severity)
                                        <x-ui.badge wire:click="setSeverity('{{ $key }}')" :color="$severity['color']"
                                            size='sm'
                                            class="cursor-pointer {{ activeBadge($key == $selected_severity) }}">
                                            {{ $severity['name'] }}
                                        </x-ui.badge>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="text-[13px] font-medium mb-2 ml-1">Status</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($statuses as $key => $status)
                                        <x-ui.badge :color="$status['color']" wire:click="setStatus('{{ $key }}')"
                                            size='sm'
                                            class="cursor-pointer {{ activeBadge($key == $selected_status) }}">
                                            {{ $status['name'] }}
                                        </x-ui.badge>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Filter -->
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-2">
                                <!-- Date -->
                                <div class="col-span-3">
                                    <label class="text-[13px] font-medium mb-2 ml-1.5">Date</label>
                                    <x-form.date-range :date_range="$date_range" width='full' placeholder='Select Date' />
                                </div>
                                <!-- Location -->
                                <div class="col-span-2">
                                    <label class="text-[13px] font-medium mb-2 ml-1.5">Location</label>
                                    <x-form.select wire:change='setLocation' model="selected_location" :data="$locations"
                                        disabled_option='Select Location' />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Notification List --}}
                    @foreach ($notifications as $notification)
                        @php
                            $config_class = $this->getConfigClass($notification['severity']);
                        @endphp
                        <div wire:click="detailNotification(@js($notification['id']))" @click="view='detail'"
                            class="p-4 cursor-pointer border-b"
                            :class="@js($active_notification['id'] === $notification['id'])
                                ?
                                'bg-gray-200' :
                                'hover:bg-gray-50'">

                            <div class="flex items-center gap-x-1">
                                <h5 class="text-sm font-semibold {{ $config_class['text'] }}">
                                    {{ $notification['title'] }}
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
                                {{ ucfirst($notification['source_type']) }} {{ $notification['tree_id'] }} •
                                {{ $notification['created_at'] }}
                            </div>
                        </div>
                    @endforeach
                    @if (!$isMaxLoaded)
                        <div x-intersect="$wire.loadMore()" class="h-6"></div>
                    @endif
                    {{-- Loading Fetch All Data --}}
                    <div wire:loading wire:target='openNotification, loadMore' class="w-full h-48">
                        <x-icons.loading size="24" class="m-auto h-full" />
                    </div>
                </div>

                <!-- RIGHT: DETAIL -->
                <div class="flex-1 p-4 md:p-6 overflow-y-auto" x-show="view === 'detail' || window.innerWidth >= 768">
                    <!-- BACK BUTTON (Mobile only) -->
                    <button @click="view='list'" class="mb-3 text-sm text-gray-600 md:hidden cursor-pointer group">
                        <span class="inline-block group-hover:-translate-x-1 transition">←</span> Kembali
                    </button>

                    <div wire:loading wire:target='detailNotification' class="w-full h-full">
                        <x-icons.loading size="48" class="m-auto h-full" />
                    </div>

                    <div wire:loading.remove wire:target='detailNotification' class="space-y-4">
                        @php
                            $config_class = $this->getConfigClass($active_notification['severity']);
                        @endphp
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <h5 class="text-lg font-semibold {{ $config_class['text'] }}">
                                    {{ $active_notification['title'] }}
                                </h5>
                                <x-ui.badge class="capitalize" size='md' :color="$config_class['badge']">
                                    {{ $active_notification['severity'] }}
                                </x-ui.badge>
                            </div>

                            <span class="text-xs text-gray-500">
                                {{ smartTimeFormat(new \Carbon\Carbon($active_notification['created_at'])) }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600">
                            {{ $active_notification['message'] }}
                        </p>

                        <div class="bg-gray-50 p-4 rounded-lg text-sm space-y-2">
                            <div class="flex justify-between">
                                <span>{{ ucwords($active_notification['sensor_type']) }}</span>
                                <span class="font-bold text-red-600">
                                    {{ $active_notification['value'] }}
                                </span>
                            </div>

                            <div class="flex justify-between text-gray-500">
                                <span>Threshold</span>
                                <span>{{ $active_notification['threshold'] }}</span>
                            </div>

                            <div class="text-xs text-gray-500">
                                Deviasi:
                                <span class="font-semibold">
                                    {{ $active_notification['value'] - $active_notification['threshold'] }}
                                </span>
                            </div>
                        </div>

                        <div class="bg-green-50 p-3 rounded-lg text-sm text-green-700">
                            💡 Rekomendasi: {{ $active_notification['recomendation'] }}
                        </div>

                        <button wire:click="resolve" wire:loading.attr='disabled'
                            wire:loading.class='cursor-wait opacity-50' wire:loading.remove.class='cursor-pointer'
                            class="w-full md:w-auto px-4 py-2 rounded-lg cursor-pointer
                        {{ $active_notification['is_active'] ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                            {{ $active_notification['is_active'] ? 'Terselesaikan' : 'Batalkan Penyelesaian' }}
                        </button>

                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
