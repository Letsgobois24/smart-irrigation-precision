<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between gap-x-2 mb-3">
        <div>
            <h2 class="font-semibold text-gray-800">
                {{ $fieldName }} Trend
            </h2>
            <p class="text-sm text-gray-500">
                {{ $fieldName }} changes over time
            </p>
        </div>
        <div class="flex md:flex-row flex-col items-center justify-center gap-2">
            <x-form.select-time model="selectedPeriods" :data="$periods" />
        </div>

    </div>
    @if ($data && count($data) > 0)
        <div x-data="lineChart(@js($data), @js($series_options))" x-init="init()"></div>
    @endif
</div>
