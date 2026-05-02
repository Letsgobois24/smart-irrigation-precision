@php
    $isAnyNotification = count($notifications) > 0;
@endphp

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

            @if ($isNotificationLoaded && $isAnyNotification)
                <!-- LEFT: LIST -->
                <div class="w-full md:w-1/3 border-r overflow-y-auto"
                    x-show="view === 'list' || window.innerWidth >= 768">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h2 class="font-semibold">🔔 Notifikasi</h2>

                        <!-- CLOSE -->
                        <button @click="isOpenNotification = false"
                            class="rounded-md p-1 text-gray-700 hover:bg-gray-50 cursor-pointer">
                            <x-icons.cross size="20" />
                        </button>
                    </div>

                    @foreach ($notifications as $notification)
                        <div wire:click="detailNotification(@js($notification['id']))" @click="view='detail'"
                            class="p-4 cursor-pointer border-b"
                            :class="@js($active_notification['id'] === $notification['id'])
                                ?
                                'bg-gray-200' :
                                'hover:bg-gray-50'">

                            <div class="flex items-center gap-x-1">
                                <x-ui.severity-text :severity="$notification['severity']" class="text-sm font-semibold">
                                    {{ $notification['title'] }}
                                </x-ui.severity-text>

                                <div class="flex-1">
                                    @if ($notification['is_active'])
                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full block"></span>
                                    @endif
                                </div>

                                <x-ui.severity-badge :severity="$notification['severity']" class="text-[10px] px-2 py-0.5">
                                    {{ strtoupper($notification['severity']) }}
                                </x-ui.severity-badge>
                            </div>

                            <div class="text-xs text-gray-500">
                                {{ ucfirst($notification['source_type']) }} {{ $notification['tree_id'] }} •
                                {{ $notification['created_at']->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                    {{-- Loading Fetch All Data --}}
                    <div wire:loading wire:target='openNotification' class="w-full h-20">
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

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <x-ui.severity-text :severity="$active_notification['severity']" class="text-lg font-semibold">
                                    ⚠️ {{ $active_notification['title'] }}
                                </x-ui.severity-text>

                                <x-ui.severity-badge :severity="$active_notification['severity']" class="text-xs px-2 py-0.5 font-semibold">
                                    {{ strtoupper($active_notification['severity']) }}
                                </x-ui.severity-badge>
                            </div>

                            <span class="text-xs text-gray-500">
                                {{ $active_notification['created_at'] }}
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
            @elseif(!$isAnyNotification)
                <div class="w-full h-full flex flex-col items-center justify-center text-center px-4">
                    <x-icons.bell-off size="48" class="text-gray-400 mb-3" />

                    <h3 class="text-sm font-semibold text-gray-700">
                        Tidak ada notifikasi
                    </h3>

                    <p class="text-xs text-gray-500 mt-1">
                        Semua notifikasi akan muncul di sini
                    </p>
                </div>
            @else
                <div class="w-full h-full">
                    <x-icons.loading size="48" class="m-auto h-full" />
                </div>
            @endif

        </div>
    </div>
</div>
