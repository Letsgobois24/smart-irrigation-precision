@props(['model', 'data'])

<div class="relative">
    <select wire:model.change="{{ $model }}"
        class="appearance-none bg-white border border-gray-200 text-sm font-medium text-gray-700
               rounded-xl px-4 py-2 pr-10 shadow-sm
               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
               hover:border-gray-300 transition cursor-pointer w-full">

        @foreach ($data as $key => $value)
            <option value="{{ $key }}">{{ $value['name'] }}</option>
        @endforeach
    </select>

    <!-- Icons -->
    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
        <x-icons.loading size="16" wire:loading wire:target='{{ $model }}' />
        <x-icons.dropdown-line size="20" wire:loading.remove wire:target='{{ $model }}' />
    </div>
</div>
