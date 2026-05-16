<div class="bg-white rounded-xl shadow p-6 px-4 sm:px-6">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 mb-3">
        <div>
            <h2 class="text-lg font-bold text-gray-800">
                {{ $fieldName }} Trend
            </h2>
            <p class="text-sm text-gray-500">
                {{ $fieldName }} changes over time
            </p>
        </div>
        <x-form.select model="selectedPeriods" :data="$periods" disabled_option='Select Time' />

    </div>
    @if ($data && count($data) > 0)
        <div x-data="lineChart(@js($data), @js($series_options), @js($ylabel))" x-init="init()"></div>
    @else
        <div class="flex flex-col items-center justify-center py-30 text-gray-500">
            <x-icons.graph size="48" class="mb-3 text-gray-400" />
            <p class="text-sm font-medium">No data available</p>
            <p class="text-xs text-gray-400">Try changing the selected time range</p>
        </div>
    @endif
</div>
