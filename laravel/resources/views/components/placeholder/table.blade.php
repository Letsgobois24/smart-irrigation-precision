@props(['columns', 'rows'])

<table {{ $attributes }} class="min-w-full border-collapse">
    {{-- Header --}}
    <thead>
        <tr>
            @for ($i = 0; $i < $columns; $i++)
                <th class="px-4 py-4">
                    <div class="h-4 w-20 bg-gray-300 rounded"></div>
                </th>
            @endfor
        </tr>
    </thead>

    {{-- Body --}}
    <tbody class="divide-y divide-gray-100">
        @for ($row = 0; $row < $rows; $row++)
            <tr>
                @for ($i = 0; $i < $columns; $i++)
                    <td class="px-4 py-4">
                        <div class="h-6 w-14 rounded-lg bg-gray-200"></div>
                    </td>
                @endfor
            </tr>
        @endfor
    </tbody>
</table>
