<main class="bg-green-50 min-h-screen p-6 w-full">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-green-800 mb-6 flex items-center gap-2">
            🌿 Dashboard Monitoring Irigasi
        </h1>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-4">
                <!-- 🟢 Toggle Sistem (GESER) -->
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600">Sistem</span>

                    <button wire:click="toggleSystem" wire:loading.attr='disabled' wire:loading.class='cursor-not-allowed'
                        wire:loading.remove.class='cursor-pointer'
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition cursor-pointer 
                {{ $system_active ? 'bg-green-600' : 'bg-gray-300' }}">

                        <span
                            class="inline-block h-4 w-4 transform rounded-full bg-white transition
                    {{ $system_active ? 'translate-x-6' : 'translate-x-1' }}">
                        </span>
                    </button>

                    <div class="w-6 h-5 flex justify-center items-center">
                        <x-icons.loading size="16" wire:loading wire:target='toggleSystem' />
                        <span wire:loading.remove wire:target='toggleSystem'
                            class="text-xs font-semibold {{ $system_active ? 'text-green-600' : 'text-red-500' }}">
                            {{ $system_active ? 'ON' : 'OFF' }}
                        </span>
                    </div>
                </div>

                <!-- 🕒 Clock -->
                <div wire:ignore x-data="clock(@js($now))" x-init="init()" class="font-mono flex gap-x-2">
                    <span x-text="time"></span>
                    <span x-text="date"></span>
                </div>

            </div>
        </div>
    </div>
    <livewire:components.global-monitoring>
        <livewire:components.node-monitoring>
</main>
