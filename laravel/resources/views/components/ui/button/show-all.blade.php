@props(['click'])

<button {{ $attributes }} wire:click="{{ $click }}" type="button"
    class="
            inline-flex items-center justify-center
            gap-2
            px-4 py-2
            rounded-2xl
            bg-emerald-50
            border border-emerald-200
            text-sm font-medium text-emerald-700
            hover:bg-emerald-100
            hover:border-emerald-300
            active:scale-[0.98]
            transition-all cursor-pointer
            whitespace-nowrap
        ">
    <x-icons.refresh wire:loading.class='animate-spin' wire:target="{{ $click }}" size="16" />
    <span>Show All</span>
</button>
