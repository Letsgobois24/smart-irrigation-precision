@props(['title', 'description'])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow p-4 sm:p-6 overflow-hidden']) }}>
    {{-- Header --}}
    <div class="flex flex-col mb-3">
        <h2 class="text-lg font-bold text-gray-800">
            {{ $title }}
        </h2>
        <p class="text-sm text-gray-500">
            {{ $description }}
        </p>
    </div>
    {{-- Isi --}}
    {{ $slot }}
</div>
