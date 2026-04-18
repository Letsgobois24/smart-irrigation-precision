@props(['active' => false])

<a wire:navigate {{ $attributes }}
    class="
        -mx-3 block rounded-lg px-3 py-2
        text-base font-medium transition
        {{ $active ? 'bg-emerald-100 text-emerald-700' : 'text-gray-800 hover:bg-gray-50' }}
    ">
    {{ $slot }}
</a>
