<div x-init="setTimeout(() => {
    const hash = window.location.hash;
    if (hash) {
        document.querySelector(hash)?.scrollIntoView({
            behavior: 'smooth'
        });
    }
}, 100);" class="bg-linear-to-b from-green-50 to-white min-h-screen space-y-6">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-emerald-700">
                Smart Irrigation Tree Location
            </h1>

            <p class="text-gray-500 mt-1">
                Monitoring kondisi area pohon berdasarkan lokasi tanam
            </p>
        </div>

        <div class="flex items-center gap-4 text-sm">

            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                <span>Online</span>
            </div>

            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                <span>Offline</span>
            </div>

        </div>

    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl shadow-sm border border-green-100 p-5">
            <div class="text-sm text-gray-500">
                Total Tree
            </div>

            <div class="text-3xl font-bold text-gray-800 mt-1">
                {{ $summary['total'] }}
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-green-100 p-5">
            <div class="text-sm text-gray-500">
                Online
            </div>

            <div class="text-3xl font-bold text-emerald-600 mt-1">
                {{ $summary['online'] }}
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-green-100 p-5">
            <div class="text-sm text-gray-500">
                Offline
            </div>

            <div class="text-3xl font-bold text-gray-500 mt-1">
                {{ $summary['offline'] }}
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-green-100 p-5">
            <div class="text-sm text-gray-500">
                Total Alerts
            </div>

            <div class="text-3xl font-bold text-red-600 mt-1">
                {{ $summary['total_fault'] }}
            </div>
        </div>

    </div>

    {{-- Location Grid --}}
    <div dir="rtl" class="grid gap-5" style="grid-template-columns: repeat({{ $max_col }}, minmax(0, 1fr))">
        @foreach ($trees as $tree)
            {{-- Tree Card --}}
            <div dir="ltr" id="tree-{{ $tree['tree_id'] }}"
                class="bg-white rounded-3xl border overflow-hidden shadow-sm hover:shadow-xl transition duration-300 hover:-translate-y-1
                {{ $tree['is_active'] ? 'border-emerald-200' : 'border-gray-200' }}">

                {{-- Header --}}
                <div
                    class="
                    px-4 py-3 flex justify-between items-center
                    {{ $tree['is_active'] ? 'bg-emerald-500 text-white' : 'bg-gray-400 text-white' }}">
                    <div class="flex items-center gap-2">
                        <div
                            class="
                            w-3 h-3 rounded-full bg-white
                            {{ $tree['is_active'] ? 'animate-pulse' : '' }}
                        ">
                        </div>
                        <span class="font-semibold text-xs uppercase">
                            {{ $tree['is_active'] ? 'Online' : 'Offline' }}
                        </span>
                    </div>
                    <span class="font-bold text-xl">
                        {{ chr(64 + $tree['row_idx']) . $tree['col_idx'] }}
                    </span>
                </div>

                <div class="p-5">
                    {{-- Location --}}
                    <div class="flex justify-center mb-4">
                        <div
                            class="
                            w-20 h-20 rounded-full
                            bg-emerald-50
                            flex items-center justify-center
                            text-3xl
                        ">
                            🌳
                        </div>
                    </div>

                    {{-- Tree ID --}}
                    <div class="text-center mb-5">
                        <div class="text-xs uppercase text-gray-500">
                            Tree ID
                        </div>
                        <div class="text-3xl font-bold text-emerald-700">
                            #{{ $tree['tree_id'] }}
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="space-y-3 text-sm">

                        <div class="flex sm:justify-between justify-center">
                            <span class="text-gray-500 hidden sm:block">
                                Variant
                            </span>

                            <span class="font-semibold text-gray-800">
                                {{ ucfirst($tree['variant']) }} Avocado
                            </span>
                        </div>

                        <div class="flex sm:justify-between justify-center">
                            <span class="text-gray-500 hidden sm:block">
                                Node
                            </span>

                            <span class="font-semibold text-gray-800">
                                Node {{ $tree['node_id'] }}
                            </span>
                        </div>

                    </div>

                    {{-- Alert --}}
                    <div class="mt-5">

                        @if ($tree['notifications_count'] > 0)
                            <div class="rounded-2xl bg-red-50 text-red-700 p-3 text-center font-semibold">
                                ⚠ {{ $tree['notifications_count'] }}
                                {{ Str::plural('Alert', $tree['notifications_count']) }}
                            </div>
                        @else
                            <div class="rounded-2xl bg-emerald-50 text-emerald-700 p-3 text-center font-semibold">
                                ✓ No Alert
                            </div>
                        @endif

                    </div>

                    {{-- Coordinates --}}
                    <div class="mt-4 text-xs text-center text-gray-400">
                        {{ $tree['latitude'] }},
                        {{ $tree['longitude'] }}
                    </div>

                    {{-- Action --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-5">
                        <a href="https://www.google.com/maps?q={{ $tree['latitude'] }},{{ $tree['longitude'] }}"
                            target="_blank"
                            class="flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-center py-2.5 rounded-xl font-medium">
                            <x-icons.location size="20" />
                            Maps
                        </a>
                        <button x-on:click="$dispatch('filter-location', {tree_id: @js($tree['tree_id'])})"
                            @disabled($tree['notifications_count'] === 0)
                            class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl font-medium transition
                                    {{ $tree['notifications_count'] > 0
                                        ? 'bg-amber-500 hover:bg-amber-600 text-white cursor-pointer'
                                        : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}">
                            <x-icons.bell size="20" />
                            Alerts
                        </button>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

</div>
