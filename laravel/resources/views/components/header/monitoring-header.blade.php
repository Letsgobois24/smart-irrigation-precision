@props(['icon', 'title', 'description'])

<div
    class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-5 bg-white rounded-2xl border border-green-100 shadow-sm px-5 py-4">

    <!-- LEFT -->
    <div class="flex items-center justify-between gap-4">

        <div class="flex items-center gap-3">

            <!-- Node Icon -->
            <div
                class="w-11 h-11 rounded-xl bg-linear-to-br from-green-500 to-emerald-600 text-white flex items-center justify-center shadow-md">
                {{ $icon }}
            </div>

            <!-- Node Info -->
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $title }}
                    </h3>

                    <!-- Badge -->
                    @isset($badge)
                        {{ $badge }}
                    @endisset

                </div>

                <p class="text-sm text-gray-500">
                    {{ $description }}
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
