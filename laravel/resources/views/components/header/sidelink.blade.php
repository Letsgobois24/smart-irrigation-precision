@props(['href'])

@php
    if ($href != '/') {
        $isActive = request()->is(trim($href, '/'));
    } else {
        $isActive = request()->is($href);
    }
@endphp

<a wire:navigate.hover href="{{ $href }}" @class([
    '-mx-3 block rounded-lg px-3 py-2 text-base font-medium transition',
    'bg-emerald-100 text-emerald-700' => $isActive,
    'text-gray-800 hover:bg-gray-50' => !$isActive,
])>
    {{ $slot }}
</a>
