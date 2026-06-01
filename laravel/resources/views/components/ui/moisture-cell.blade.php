<div class="flex items-center gap-2">
    <div class="w-16 bg-gray-200 rounded-full h-2 overflow-hidden">
        <div class="h-2 rounded-full {{ $barColor() }}" style="width: {{ $value }}%">
        </div>
    </div>
    <x-ui.badge size='sm' :color="$badgeColor()">
        {{ number_format($value, 1) }}%
    </x-ui.badge>
</div>
