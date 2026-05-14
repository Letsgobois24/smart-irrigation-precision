<div class="animate-pulse">
    {{-- Date Range Skeleton --}}
    <div class="mb-4 w-full sm:w-64">
        <div class="h-10 rounded-xl bg-gray-200"></div>
    </div>

    {{-- Table Skeleton --}}
    <div class="overflow-x-auto rounded-xl border border-gray-100">
        <table class="min-w-full border-collapse">
            {{-- Header --}}
            <thead class="bg-green-50">
                <tr>
                    @for ($i = 0; $i < 10; $i++)
                        <th class="px-4 py-3">
                            <div class="h-4 w-20 bg-green-100 rounded"></div>
                        </th>
                    @endfor
                </tr>
            </thead>

            {{-- Body --}}
            <tbody class="divide-y divide-gray-100">
                @for ($row = 0; $row < 5; $row++)
                    <tr>
                        {{-- Tree --}}
                        <td class="px-4 py-3">
                            <div class="h-6 w-10 rounded-lg bg-green-100"></div>
                        </td>

                        {{-- Valve --}}
                        <td class="px-4 py-3">
                            <div class="h-6 w-14 rounded-lg bg-gray-200"></div>
                        </td>

                        {{-- Time --}}
                        <td class="px-4 py-3">
                            <div class="h-4 w-24 rounded bg-gray-200"></div>
                        </td>

                        {{-- Current Before --}}
                        <td class="px-4 py-3">
                            <div class="h-4 w-16 rounded bg-gray-200"></div>
                        </td>

                        {{-- Current Avg --}}
                        <td class="px-4 py-3">
                            <div class="h-4 w-16 rounded bg-blue-100"></div>
                        </td>

                        {{-- Current After --}}
                        <td class="px-4 py-3">
                            <div class="h-4 w-16 rounded bg-gray-200"></div>
                        </td>

                        {{-- Moisture Before --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-16 h-2 rounded-full bg-gray-200"></div>
                                <div class="h-4 w-8 rounded bg-gray-200"></div>
                            </div>
                        </td>

                        {{-- Moisture After --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-16 h-2 rounded-full bg-gray-200"></div>
                                <div class="h-4 w-8 rounded bg-gray-200"></div>
                            </div>
                        </td>

                        {{-- Duration --}}
                        <td class="px-4 py-3">
                            <div class="h-4 w-12 rounded bg-gray-200"></div>
                        </td>

                        {{-- Water Flow --}}
                        <td class="px-4 py-3">
                            <div class="h-6 w-14 rounded-lg bg-blue-100"></div>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    {{-- Pagination Skeleton --}}
    <div class="flex sm:flex-row flex-col-reverse sm:justify-between items-center mt-4 gap-3">
        {{-- Count --}}
        <div class="h-4 w-52 rounded bg-gray-200"></div>

        {{-- Buttons --}}
        <div class="flex items-center gap-2">
            <div class="h-10 w-20 rounded-lg bg-gray-200"></div>

            <div class="h-4 w-16 rounded bg-gray-200"></div>

            <div class="h-10 w-20 rounded-lg bg-green-100"></div>
        </div>
    </div>
</div>
