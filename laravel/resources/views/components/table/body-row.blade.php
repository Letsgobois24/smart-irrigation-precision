<tr class="hover:bg-gray-50 transition font-mono">

    {{-- Tree ID --}}
    <td class="px-4 py-3 border-r border-green-200">
        <x-ui.badge size='sm' color="green">
            {{ $row['tree_id'] }}
        </x-ui.badge>
    </td>

    {{-- Valve --}}
    <td class="px-4 py-3 font-sans border-r border-green-200">
        <x-ui.badge size='sm' :color="$row['valve'] ? 'green' : 'red'">
            {{ $row['valve'] ? 'ON' : 'OFF' }}
        </x-ui.badge>
    </td>

    {{-- Current Before --}}
    <td class="px-4 py-3 font-medium {{ $row['current_before'] < 1 ? 'text-gray-700' : 'text-blue-700' }}">
        {{ number_format($row['current_before'], 1) }}
    </td>

    {{-- Duration --}}
    <td class="px-4 py-3 text-gray-700 font-medium whitespace-nowrap">
        {{ number_format($row['current_stable_duration'], 2) }} s
    </td>

    {{-- Current Stable --}}
    <td class="px-4 py-3 font-medium {{ $row['current_stable'] < 1 ? 'text-gray-700' : 'text-blue-700' }}">
        {{ number_format($row['current_stable'], 1) }}
    </td>

    {{-- Current Delta --}}
    <td class="px-4 py-3">
        <x-ui.badge size='sm' :color="$currentDelta > 0 ? 'green' : 'red'">
            {{ sprintf('%+.1f', number_format($currentDelta, 1)) }}
        </x-ui.badge>
    </td>

    {{-- Current Average --}}
    <td class="px-4 py-3 border-r border-green-200">
        <x-ui.badge size='sm' color="gray">
            {{ number_format($row['current_avg'], 1) }}
        </x-ui.badge>
    </td>

    {{-- Moisture Before --}}
    <td class="px-4 py-3">
        <x-ui.moisture-cell :value="$row['moisture_before']" />
    </td>

    {{-- Moisture Duration --}}
    <td class="px-4 py-3 text-gray-700 font-medium">
        {{ $row['moisture_duration'] }} s
    </td>

    {{-- Moisture After --}}
    <td class="px-4 py-3">
        <x-ui.moisture-cell :value="$row['moisture_after']" />
    </td>

    {{-- Moisture Delta --}}
    <td class="px-4 py-3 border-r border-green-200">
        <x-ui.badge size='sm' :color="$row['moisture_delta'] > 0 ? 'green' : 'red'">
            {{ sprintf('%+.1f', number_format($row['moisture_delta'], 1)) }}%
        </x-ui.badge>
    </td>

    {{-- Anomaly Flag --}}
    <td class="px-4 py-3 font-sans">
        <x-ui.badge size='sm' :color="$isAnomaly ? 'red' : 'green'">
            {{ $isAnomaly ? 'Anomaly' : 'Normal' }}
        </x-ui.badge>
    </td>

    {{-- Anomaly Score --}}
    <td class="px-4 py-3 border-r border-green-200">
        <x-ui.badge size='sm' :color="$row['anomaly_score'] >= 70 ? 'red' : ($row['anomaly_score'] >= 40 ? 'yellow' : 'green')">
            {{ $row['anomaly_score'] }}%
        </x-ui.badge>
    </td>

    {{-- Time --}}
    <td class="px-4 py-3 font-sans text-gray-500 whitespace-nowrap">
        {{ smartTimeFormat($row['time']) }}
    </td>

</tr>
