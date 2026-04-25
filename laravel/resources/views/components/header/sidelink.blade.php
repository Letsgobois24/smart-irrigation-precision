@props(['href'])

<a wire:navigate href="{{ $href }}"
    class="
        -mx-3 block rounded-lg px-3 py-2
        text-base font-medium transition
        {{ request()->is(substr($href, 1)) ? 'bg-emerald-100 text-emerald-700' : 'text-gray-800 hover:bg-gray-50' }}
    ">
    {{ $slot }}
</a>
