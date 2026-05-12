{{-- Table --}}
<div class="overflow-x-auto rounded-xl border border-gray-100">

    <table class="min-w-full text-sm text-left border-collapse">
        <thead class="bg-green-50 text-green-800">
            <tr>
                <th class="px-4 py-3 font-semibold whitespace-nowrap">
                    Tree
                </th>
                <th class="px-4 py-3 font-semibold whitespace-nowrap">
                    Current Before
                </th>
                <th class="px-4 py-3 font-semibold whitespace-nowrap">
                    Current Avg
                </th>
                <th class="px-4 py-3 font-semibold whitespace-nowrap">
                    Current After 2s
                </th>
                <th class="px-4 py-3 font-semibold whitespace-nowrap">
                    Moisture Before
                </th>
                <th class="px-4 py-3 font-semibold whitespace-nowrap">
                    Moisture After
                </th>
                <th class="px-4 py-3 font-semibold whitespace-nowrap">
                    Duration
                </th>
                <th class="px-4 py-3 font-semibold whitespace-nowrap">
                    Water Flow
                </th>
                <th class="px-4 py-3 font-semibold whitespace-nowrap">
                    Time
                </th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse ($events as $event)
                <tr class="hover:bg-gray-50 transition">

                    {{-- Tree ID --}}
                    <td class="px-4 py-3 flex justify-center">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg text-xs font-semibold">
                            {{ $event['tree_id'] }}
                        </span>
                    </td>

                    {{-- Current Before --}}
                    <td class="px-4 py-3 font-medium text-gray-700">
                        {{ $event['current_before'] }} A
                    </td>

                    {{-- Current Avg --}}
                    <td class="px-4 py-3 font-medium text-blue-600">
                        {{ $event['current_avg'] }} A
                    </td>

                    {{-- Current After 2s --}}
                    <td class="px-4 py-3 font-medium text-gray-700">
                        {{ $event['current_after_2s'] }} A
                    </td>

                    {{-- Moisture Before --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full"
                                    style="width: {{ $event['moisture_before'] }}%">
                                </div>
                            </div>

                            <span class="text-xs font-semibold text-gray-700">
                                {{ $event['moisture_before'] }}%
                            </span>
                        </div>
                    </td>

                    {{-- Moisture After 10m --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full"
                                    style="width: {{ $event['moisture_after_10m'] }}%">
                                </div>
                            </div>

                            <span class="text-xs font-semibold text-gray-700">
                                {{ $event['moisture_after_10m'] }}%
                            </span>
                        </div>
                    </td>

                    {{-- Duration --}}
                    <td class="px-4 py-3 text-gray-700 font-medium">
                        {{ $event['duration'] }} s
                    </td>

                    {{-- Water Flow --}}
                    <td class="px-4 py-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-lg text-xs font-semibold">
                            {{ $event['water_flow'] }} L
                        </span>
                    </td>



                    {{-- Time --}}
                    <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                        {{ $event['time']->diffForHumans() }}
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-10 text-gray-400">
                        Tidak ada data system event
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>
