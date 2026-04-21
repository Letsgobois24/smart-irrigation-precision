@props(['model', 'data'])

<select wire:ignore wire:model.change="{{ $model }}"
    class="appearance-none bg-white border border-gray-200 text-sm font-medium text-gray-700 
                           rounded-xl px-4 py-2 pr-10 shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           hover:border-gray-300 transition">
    @foreach ($data as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>
