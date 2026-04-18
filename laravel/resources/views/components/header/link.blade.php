@props(['active' => false])

<a wire:navigate.hover {{ $attributes }} aria-current="{{ $active ?? 'page' }}"
    class="{{ $active
        ? 'after:scale-x-100'
        : 'after:scale-x-0 after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-gray-100 after:transition after:duration-300 hover:after:scale-x-100' }} relative inline-block py-1 after:content-[''] after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-gray-100">
    {{ $slot }}
</a>
