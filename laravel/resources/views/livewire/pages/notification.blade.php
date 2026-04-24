<div x-data="{ isOpenModal: true }">
    <div x-show="isOpenModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <!-- Modal -->
        <div @click.outside="isOpenModal = false"
            class="bg-white w-full max-w-4xl h-[80vh] rounded-2xl shadow-xl flex overflow-hidden">
            <!-- LEFT: Notification List -->
            <div class="w-1/3 border-r overflow-y-auto">

                <div class="flex justify-between items-center p-4 pr-2 font-semibold border-b">
                    <h2>🔔 Notifikasi</h2>
                    <button type="button" @click="isOpenModal = false"
                        class="cursor-pointer rounded-md p-1 text-gray-700 hover:bg-gray-50">
                        <x-icons.cross size="20" />
                    </button>
                </div>

                <!-- LEFT: Notifications -->
                @foreach ($notifications as $notification)
                    <div wire:click="detailNotification(@js($notification['id']))"
                        class="p-4 cursor-pointer hover:bg-gray-50 border-b">
                        <div class="text-sm font-semibold text-yellow-600">
                            {{ $notification['title'] }}
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

                    {{-- Title --}}
                    <div class="flex justify-between items-center gap-x-2">
                        <h2 class="text-lg font-semibold text-red-600">
                            ⚠️ {{ $active_notification['title'] }}
                        </h2>
                        {{-- Time --}}
                        <span class="text-sm text-gray-800">{{ $active_notification['created_at'] }}</span>
                        {{-- Message --}}
                    </div>
                    <p class="text-sm text-gray-600">
                        {{ $active_notification['message'] }}
                    </p>
                    <div class="bg-gray-50 p-4 rounded-lg text-sm">
                        {{-- Value --}}
                        <div class="flex justify-between">
                            <span>{{ ucwords($active_notification['sensor_type']) }}</span>
                            <span class="font-semibold text-red-600">{{ $active_notification['value'] }}</span>
                        </div>
                        {{-- Threshold --}}
                        <div class="flex justify-between">
                            <span>Threshold</span>
                            <span>{{ $active_notification['threshold'] }}</span>
                        </div>
                    </div>

                    {{-- Recomendation --}}
                    <div class="bg-green-50 p-3 rounded-lg text-sm text-green-700">
                        💡 Rekomendasi: {{ $active_notification['recomendation'] }}
                    </div>

                    <div class="flex gap-2">
                        @if (!$active_notification['is_read'])
                            <button class="px-4 py-2 bg-gray-200 rounded-lg cursor-pointer">
                                Tandai Dibaca
                            </button>
                        @endif
                        @if ($active_notification['is_active'])
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg cursor-pointer">
                                Resolve
                            </button>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
