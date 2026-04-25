<div x-data="{ isOpenNotification: false }">
    <button @click="isOpenNotification = true"
        class="flex relative cursor-pointer ml-3 mr-7 size-10 justify-center items-center rounded-full hover:bg-green-50/30">
        @if ($count_notifications > 0)
            <div
                class="absolute top-0.5 right-1 bg-orange-500 size-4 rounded-full flex justify-center items-center text-xs">
                {{ $count_notifications }}</div>
        @endif
        <x-icons.notification size='30' class="text-gray-100" />
    </button>
    <div x-show="isOpenNotification" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <!-- Modal -->
        <div @click.outside="isOpenNotification = false"
            class="bg-white w-full max-w-5xl h-[80vh] rounded-2xl shadow-xl flex overflow-hidden">
            <!-- LEFT: Notification List -->
            <div class="w-1/3 border-r overflow-y-auto">

                <div class="flex justify-between items-center p-4 pr-2 font-semibold border-b border-gray-500">
                    <h2>🔔 Notifikasi</h2>
                    <button type="button" @click="isOpenNotification = false"
                        class="cursor-pointer rounded-md p-1 text-gray-700 hover:bg-gray-50">
                        <x-icons.cross size="20" />
                    </button>
                </div>

                <!-- LEFT: Notifications -->
                @foreach ($notifications as $notification)
                    <div wire:click="detailNotification(@js($notification['id']))"
                        class="p-4 cursor-pointer border-b border-gray-400"
                        :class="{
                            'bg-gray-200': @js($active_notification['id'] ?? 'null') === @js($notification['id']),
                            'hover:bg-gray-50': true
                        }">
                        <div class="flex items-center gap-x-1">
                            {{-- UNREAD DOT --}}
                            <x-ui.severity-text :severity="$notification['severity']" class="text-sm font-semibold">
                                {{ $notification['title'] }}
                            </x-ui.severity-text>

                            <div class="flex-1">
                                @if ($notification['is_active'])
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full block"></span>
                                @else
                                    <span class="w-1.5 h-1.5"></span> {{-- placeholder biar rata --}}
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

            </div>

            <!-- RIGHT: Detail -->
            <div class="flex-1 p-6 overflow-y-auto">
                <div wire:loading wire:target='detailNotification' class="w-full h-[98%]">
                    <x-icons.loading size="48" class="m-auto h-full" />
                </div>
                <div wire:loading.remove wire:target='detailNotification' class="space-y-4">
                    <div class="flex items-center justify-between">
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

                    {{-- Recomendation --}}
                    <div class="bg-green-50 p-3 rounded-lg text-sm text-green-700">
                        💡 Rekomendasi: {{ $active_notification['recomendation'] }}
                    </div>

                    <div class="flex gap-x-3 items-center">
                        <button wire:click="resolve" wire:loading.attr='disabled'
                            wire:loading.class='cursor-not-allowed opacity-50'
                            wire:loading.remove.class='cursor-pointer'
                            class="flex items-center gap-x-1 px-4 py-2 rounded-lg cursor-pointer {{ $active_notification['is_active']
                                ? 'bg-blue-600 text-white hover:bg-blue-700'
                                : 'bg-gray-200 hover:bg-gray-300' }}">
                            @if ($active_notification['is_active'])
                                <x-icons.check size="22" class="font-semibold" />Terselesaikan
                            @else
                                <x-icons.cross size="22" class="font-semibold" />Batalkan Penyelesaian
                            @endif
                        </button>
                        <x-icons.loading size="22" wire:loading wire:target='resolve' />
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
