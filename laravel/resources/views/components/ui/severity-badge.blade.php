@props(['severity'])

@php
    $classes = [
        'tinggi' => 'bg-red-100 text-red-600',
        'sedang' => 'bg-yellow-100 text-yellow-600',
        'rendah' => 'bg-green-100 text-green-600',
    ];
@endphp

<span {{ $attributes->merge([
    'class' => "rounded-full $classes[$severity]",
]) }}>
    {{ $slot }}
</span>
