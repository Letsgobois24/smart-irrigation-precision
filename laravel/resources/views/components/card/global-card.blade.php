@props(['config', 'data'])

<div
    class="bg-white rounded-2xl border-l-4 shadow-sm hover:shadow-md p-4 transition 
    {{ $config['border'] }}
    {{ $config['accent'] }}">
    <div class="flex justify-between items-start mb-3">
        <div class="flex items-center gap-3">
            <div class="p-2 rounded-xl {{ $config['bg-icon'] }} {{ $config['text'] }}">
                {{ $icon }}
            </div>
            <div>
                <p class="text-sm text-gray-500">
                    {{ $config['title'] }}
                </p>
                <h3 class="text-2xl font-bold {{ $config['text'] }}">
                    {{ $data }}
                </h3>
            </div>
        </div>
        <x-ui.badge class="capitalize" :color="$config['color']" size='sm'>
            {{ $config['label'] }}
        </x-ui.badge>
    </div>

    {{-- Description --}}
    <p class="text-xs text-gray-600">
        {{ $config['description'] }}
    </p>
</div>
