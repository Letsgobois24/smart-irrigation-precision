<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between gap-x-2">
        <div>
            <h2 class="font-semibold text-gray-800">
                {{ $field }} Trend
            </h2>
            <p class="text-sm text-gray-500">
                {{ $field }} changes over time
            </p>
        </div>
        <div class="flex md:flex-row flex-col items-center justify-center gap-2">
            <x-form.select-time model="selectedInterval" :data="$intervals" />
            <x-form.select-time model="selectedHour" :data="$hours" />
        </div>

    </div>
    <div x-data="lineChart(@js($data), @js($field))" x-init="init()"></div>
</div>
