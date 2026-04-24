<div x-data="{ open: true, selected: null }">

    ```
    <!-- Overlay -->
    <div x-show="open" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

        <!-- Modal -->
        <div class="bg-white w-full max-w-4xl h-[80vh] rounded-2xl shadow-xl flex overflow-hidden">

            <!-- LEFT: Notification List -->
            <div class="w-1/3 border-r overflow-y-auto">

                <div class="p-4 font-semibold border-b">
                    🔔 Notifikasi
                </div>

                <!-- Item -->
                <div class="p-4 cursor-pointer hover:bg-gray-50 border-b" @click="selected = 1">
                    <div class="text-sm font-semibold text-red-600">
                        Kelembapan Rendah
                    </div>
                    <div class="text-xs text-gray-500">
                        Zona 2 • 07:15
                    </div>
                </div>

                <div class="p-4 cursor-pointer hover:bg-gray-50 border-b" @click="selected = 2">
                    <div class="text-sm font-semibold text-yellow-600">
                        Flow Tidak Normal
                    </div>
                    <div class="text-xs text-gray-500">
                        Zona 1 • 06:50
                    </div>
                </div>

            </div>

            <!-- RIGHT: Detail -->
            <div class="flex-1 p-6 overflow-y-auto">

                <template x-if="!selected">
                    <div class="text-gray-400 text-center mt-20">
                        Pilih notifikasi untuk melihat detail
                    </div>
                </template>

                <!-- Detail 1 -->
                <template x-if="selected === 1">
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-red-600">
                            ⚠️ Kelembapan Tanah Rendah
                        </h2>

                        <p class="text-sm text-gray-600">
                            Kelembapan tanah berada di bawah threshold optimal selama 15 menit.
                        </p>

                        <div class="bg-gray-50 p-4 rounded-lg text-sm">
                            <div class="flex justify-between">
                                <span>Nilai</span>
                                <span class="font-semibold text-red-600">32%</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Threshold</span>
                                <span>45%</span>
                            </div>
                        </div>

                        <div class="bg-green-50 p-3 rounded-lg text-sm text-green-700">
                            💡 Rekomendasi: Aktifkan irigasi
                        </div>

                        <div class="flex gap-2">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                                Aktifkan Valve
                            </button>
                            <button class="px-4 py-2 bg-gray-200 rounded-lg">
                                Tandai Dibaca
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Detail 2 -->
                <template x-if="selected === 2">
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-yellow-600">
                            ⚠️ Flow Tidak Normal
                        </h2>

                        <p class="text-sm text-gray-600">
                            Terdapat aliran air meskipun valve dalam kondisi OFF.
                        </p>

                        <div class="bg-gray-50 p-4 rounded-lg text-sm">
                            <div class="flex justify-between">
                                <span>Flow</span>
                                <span class="font-semibold">2.1 L/min</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Status Valve</span>
                                <span>OFF</span>
                            </div>
                        </div>

                        <div class="bg-green-50 p-3 rounded-lg text-sm text-green-700">
                            💡 Rekomendasi: Periksa kemungkinan kebocoran
                        </div>
                    </div>
                </template>

            </div>

        </div>
    </div>
    ```

</div>
