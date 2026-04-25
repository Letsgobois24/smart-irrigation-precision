<div x-show="isOpenNotification" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <!-- Modal -->
    <div @click.outside="isOpenNotification = false"
        class="bg-white w-full max-w-4xl h-[80vh] rounded-2xl shadow-xl flex overflow-hidden">
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
                        'bg-gray-200': {{ $active_notification['id'] ?? 'null' }} === {{ $notification['id'] }},
                        'hover:bg-gray-50': true
                    }">
                    <div class="flex items-center gap-x-1">
                        {{-- UNREAD DOT --}}
                        <div class="text-sm font-semibold"
                            :class="{
                                'text-red-600': '{{ $notification['severity'] }}'
                                === 'tinggi',
                                'text-yellow-600': '{{ $notification['severity'] }}'
                                === 'sedang',
                                'text-green-600': '{{ $notification['severity'] }}'
                                === 'rendah'
                            }">
                            {{ $notification['title'] }}
                        </div>

                        <div class="flex-1">
                            @if ($notification['is_active'])
                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full block"></span>
                            @else
                                <span class="w-1.5 h-1.5"></span> {{-- placeholder biar rata --}}
                            @endif
                        </div>

                        <span class="text-[10px] px-2 py-0.5 rounded-full"
                            :class="{
                                'bg-red-100 text-red-600': '{{ $notification['severity'] }}'
                                === 'tinggi',
                                'bg-yellow-100 text-yellow-600': '{{ $notification['severity'] }}'
                                === 'sedang',
                                'bg-green-100 text-green-600': '{{ $notification['severity'] }}'
                                === 'rendah'
                            }">
                            {{ strtoupper($notification['severity']) }}
                        </span>
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
                        <span class="text-lg font-semibold"
                            :class="{
                                'text-red-600': '{{ $active_notification['severity'] }}'
                                === 'tinggi',
                                'text-yellow-600': '{{ $active_notification['severity'] }}'
                                === 'sedang',
                                'text-green-600': '{{ $active_notification['severity'] }}'
                                === 'rendah'
                            }">
                            ⚠️ {{ $active_notification['title'] }}
                        </span>

                        <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                            :class="{
                                'bg-red-100 text-red-600': '{{ $active_notification['severity'] }}'
                                === 'tinggi',
                                'bg-yellow-100 text-yellow-600': '{{ $active_notification['severity'] }}'
                                === 'sedang',
                                'bg-green-100 text-green-600': '{{ $active_notification['severity'] }}'
                                === 'rendah'
                            }">
                            {{ strtoupper($active_notification['severity']) }}
                        </span>
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
                        wire:loading.class='cursor-not-allowed opacity-50' wire:loading.remove.class='cursor-pointer'
                        class="flex items-center gap-x-1 px-4 py-2 rounded-lg cursor-pointer {{ $active_notification['is_active']
                            ? 'bg-blue-600 text-white hover:bg-blue-700'
                            : 'bg-gray-200 hover:bg-gray-300' }}">
                        @if ($active_notification['is_active'])
                            <x-icons.check size="22" class="font-semibold" />Terselesaikan
                        @else
                            <x-icons.cross size="22" class="font-semibold" />Belum Terselesaikan
                        @endif
                    </button>
                    <x-icons.loading size="22" wire:loading wire:target='resolve' />
                </div>


            </div>
        </div>

    </div>
</div>
