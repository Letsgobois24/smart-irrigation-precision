<div class="flex items-center gap-3">
    {{-- Status Chip --}}
    <div
        class="flex items-center gap-2 px-3 py-1 rounded-full
                {{ $system_active ? 'bg-green-500/10 border border-green-500/20' : 'bg-red-500/10 border border-red-500/20' }}">

        <span
            class="w-2 h-2 rounded-full
                   {{ $system_active ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}">
        </span>

        <span
            class="text-xs font-medium uppercase tracking-wide
                   {{ $system_active ? 'text-green-600' : 'text-red-600' }}">
            {{ $system_active ? 'ONLINE' : 'OFFLINE' }}
        </span>
    </div>

    {{-- Toggle --}}
    <button wire:click="toggleSystem" wire:loading.attr="disabled" wire:loading.class="cursor-wait opacity-60"
        class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-200 cursor-pointer
               {{ $system_active ? 'bg-green-600' : 'bg-gray-400' }}">

        <span
            class="inline-block h-4 w-4 transform rounded-full bg-white transition
                   {{ $system_active ? 'translate-x-6' : 'translate-x-1' }}">
        </span>
    </button>

    {{-- Loading --}}
    <div class="flex items-center justify-center w-5">
        <x-icons.loading size="20" wire:loading wire:target="toggleSystem" class='text-gray-500' />
    </div>
</div>
