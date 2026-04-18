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
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M20 8.04L7.878 20.164a2.857 2.857 0 1 1-4.041-4.04L15.959 4M7 13h8m4 2l1.5 1.6a2 2 0 1 1-3 0zM15 3l6 6" />
                </svg>
                <div>
                    <p class="text-gray-500 text-sm">pH</p>
                    <p class="text-xl font-bold text-green-700">6.8</p>
                </div>
            </div>

            <!-- Debit Air -->
            <div class="bg-white shadow rounded-xl p-4 flex items-center gap-3">
                <svg class="text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 14 14">
                    <path fill="currentColor" fill-rule="evenodd"
                        d="M11.673.834a.75.75 0 0 0-1.085.796l.168.946q-.676.14-1.369.173c-.747-.004-1.315-.287-2.041-.665l-.04-.02c-.703-.366-1.564-.814-2.71-.814h-.034A10.4 10.4 0 0 0 .416 2.328a.75.75 0 1 0 .668 1.343a8.9 8.9 0 0 1 3.529-.921c.747.004 1.315.287 2.041.665l.04.02c.703.366 1.564.815 2.71.815l.034-.001a10.3 10.3 0 0 0 4.146-1.078a.75.75 0 0 0 .338-1.005a.75.75 0 0 0-.334-.336zM4.562 5.751l.034-.001c1.146 0 2.007.448 2.71.814l.04.02c.726.378 1.294.662 2.041.666q.707-.034 1.398-.18l-.192-.916a.75.75 0 0 1 1.08-.82l1.915.996a.747.747 0 0 1 .36.943a.75.75 0 0 1-.364.399a10.5 10.5 0 0 1-1.705.668a10.3 10.3 0 0 1-2.475.41c-1.146 0-2.007-.448-2.71-.814l-.04-.02c-.726-.378-1.294-.662-2.041-.666a8.9 8.9 0 0 0-3.53.922a.75.75 0 1 1-.667-1.344a10.4 10.4 0 0 1 4.146-1.077m0 4.5h.034c1.146 0 2.007.448 2.71.814l.04.02c.726.378 1.294.661 2.041.665a9 9 0 0 0 1.402-.18l-.195-.912a.75.75 0 0 1 1.079-.823l1.915.996a.747.747 0 0 1 .36.942a.75.75 0 0 1-.364.4a10.4 10.4 0 0 1-4.18 1.078c-1.146 0-2.007-.449-2.71-.815l-.04-.02c-.726-.378-1.294-.661-2.041-.665a8.9 8.9 0 0 0-3.53.921a.75.75 0 1 1-.667-1.343a10.4 10.4 0 0 1 4.146-1.078"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-gray-500 text-sm">Debit Air</p>
                    <p class="text-xl font-bold text-green-700">120 L/min</p>
                </div>
            </div>

            <!-- Valve -->
            <div class="bg-white shadow rounded-xl p-4 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-2" width="32" height="32"
                    viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M192 96v12L96 96c-17.7 0-32 14.3-32 32s14.3 32 32 32l96-12l31-3.9l1-.1l1 .1l31 3.9l96 12c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 12V96c0-17.7-14.3-32-32-32s-32 14.3-32 32M32 256c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32h100.1c20.2 29 53.9 48 91.9 48s71.7-19 91.9-48H352c17.7 0 32 14.3 32 32s14.3 32 32 32h64c17.7 0 32-14.3 32-32c0-88.4-71.6-160-160-160h-32l-22.6-22.6c-6-6-14.1-9.4-22.6-9.4H256v-43.8l-32-4l-32 4V224h-18.7c-8.5 0-16.6 3.4-22.6 9.4L128 256z"
                        stroke-width="13" stroke="currentColor" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M224 0c17.7 0 32 14.3 32 32v12l96-12c17.7 0 32 14.3 32 32s-14.3 32-32 32l-96-12l-31-3.9l-1-.1l-1 .1l-31 3.9l-96 12c-17.7 0-32-14.3-32-32s14.3-32 32-32l96 12V32c0-17.7 14.3-32 32-32M0 224c0-17.7 14.3-32 32-32h96l22.6-22.6c6-6 14.1-9.4 22.6-9.4h18.7v-43.8l32-4l32 4V160h18.7c8.5 0 16.6 3.4 22.6 9.4L320 192h32c88.4 0 160 71.6 160 160c0 17.7-14.3 32-32 32h-64c-17.7 0-32-14.3-32-32s-14.3-32-32-32h-36.1c-20.2 29-53.9 48-91.9 48s-71.7-19-91.9-48H32c-17.7 0-32-14.3-32-32zm436.8 199.4c1.9-4.5 6.3-7.4 11.2-7.4s9.2 2.9 11.2 7.4l18.2 42.4c1.8 4.1 2.7 8.6 2.7 13.1v1.2c0 17.7-14.3 32-32 32s-32-14.3-32-32v-1.2c0-4.5.9-8.9 2.7-13.1l18.2-42.4z"
                        stroke-width="13" stroke="currentColor" />
                </svg>
                <div>
                    <p class="text-gray-500 text-sm">Status Valve</p>
                    <span class="px-2 py-1 text-xs bg-green-200 text-green-800 rounded-full">
                        Aktif
                    </span>
                </div>
            </div>

            <!-- Update -->
            <div class="bg-white shadow rounded-xl p-4 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-gray-500 text-sm">Update Terakhir</p>
                    <p class="text-sm font-semibold">18 Apr 2026</p>
                </div>
                <div class="ml-auto cursor-pointer hover:bg-gray-200 rounded-lg p-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="animate-spin" width="28" height="28"
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M20 11A8.1 8.1 0 0 0 4.5 9M4 5v4h4m-4 4a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                    </svg>
                </div>
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
                <span class="text-sm text-gray-500">Update: 18 Apr 2026</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

                <!-- Tree 1 -->
                <div class="bg-green-50 p-3 rounded-lg">
                    <div class="flex items-center gap-2 mb-1">
                        🌱 <p class="text-sm text-gray-500">Tree 1</p>
                    </div>

                    <!-- Moisture -->
                    <div class="flex items-center gap-2">
                        <!-- icon kelembaban -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M12 2C8 7 5 10 5 14a7 7 0 0014 0c0-4-3-7-7-12z" />
                        </svg>

                        <p class="font-bold">60%</p>
                    </div>

                    <!-- Valve -->
                    <div class="flex items-center gap-1 mt-1">
                        ⚙️
                        <p class="text-xs text-green-600">Valve ON</p>
                    </div>
                </div>

                <!-- Tree 2 -->
                <div class="bg-green-50 p-3 rounded-lg">
                    <div class="flex items-center gap-2 mb-1">
                        🌱 <p class="text-sm text-gray-500">Tree 2</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M12 2C8 7 5 10 5 14a7 7 0 0014 0c0-4-3-7-7-12z" />
                        </svg>

                        <p class="font-bold">55%</p>
                    </div>

                    <div class="flex items-center gap-1 mt-1">
                        ⚙️
                        <p class="text-xs text-red-600">Valve OFF</p>
                    </div>
                </div>

                <!-- Tree 3 -->
                <div class="bg-green-50 p-3 rounded-lg">
                    <div class="flex items-center gap-2 mb-1">
                        🌱 <p class="text-sm text-gray-500">Tree 3</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M12 2C8 7 5 10 5 14a7 7 0 0014 0c0-4-3-7-7-12z" />
                        </svg>

                        <p class="font-bold">70%</p>
                    </div>

                    <div class="flex items-center gap-1 mt-1">
                        ⚙️
                        <p class="text-xs text-green-600">Valve ON</p>
                    </div>
                </div>

                <!-- Tree 4 -->
                <div class="bg-green-50 p-3 rounded-lg">
                    <div class="flex items-center gap-2 mb-1">
                        🌱 <p class="text-sm text-gray-500">Tree 4</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M12 2C8 7 5 10 5 14a7 7 0 0014 0c0-4-3-7-7-12z" />
                        </svg>

                        <p class="font-bold">65%</p>
                    </div>

                    <div class="flex items-center gap-1 mt-1">
                        ⚙️
                        <p class="text-xs text-green-600">Valve ON</p>
                    </div>
                </div>
            </div>

            <div class="border rounded-xl h-64 flex items-center justify-center">
                <p class="text-gray-400">📊 Grafik Kelembaban</p>
            </div>

        </div>
    </div>

</main>
