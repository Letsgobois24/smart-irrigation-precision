@props(['date_range', 'width' => 'semi', 'placeholder' => ''])

@php
    $width_class = match ($width) {
        'full' => 'w-full',
        'semi' => 'w-full sm:max-w-72',
    };
@endphp

<div x-data x-init="$nextTick(() => dateInput = dateRange($refs.range, $wire, @js($date_range)))" class="relative">
    <input x-ref="range" type="text" placeholder="{{ $placeholder }}"
        class="{{ $width_class }}
                px-10 py-2

                bg-white/90
                border border-emerald-200
                rounded-2xl

                text-sm text-gray-700
                placeholder:text-gray-400

                shadow-sm
                backdrop-blur-sm

                focus:outline-none
                focus:ring-2
                focus:ring-emerald-500/30
                focus:border-emerald-500

                hover:border-emerald-300
                transition-all
            ">

    {{-- Calendar Icon --}}
    <div
        class="
                absolute left-4 top-1/2
                -translate-y-1/2
                text-emerald-600
            ">
        <x-icons.calendar size="18" />
    </div>

    {{-- Loading --}}
    <div wire:loading wire:target="setDateRange"
        class="
                pointer-events-none
                absolute right-3 top-1/2
                -translate-y-1/2
            ">
        <x-icons.loading size="16" class="text-gray-500" />
    </div>
</div>
