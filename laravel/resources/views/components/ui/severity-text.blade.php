@props(['severity'])

@php
    $classes = [
        'tinggi' => 'text-red-600',
        'sedang' => 'text-yellow-600',
        'rendah' => 'text-green-600',
    ];
@endphp

<span {{ $attributes->merge([
    'class' => $classes[$severity],
]) }}>
    {{ $slot }}
</span>
