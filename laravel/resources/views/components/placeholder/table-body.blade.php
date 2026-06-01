@props(['columns', 'rows'])
<tbody {{ $attributes }} wire:loading wire:loading.table-row-group>
    @for ($row = 0; $row < $rows; $row++)
        <tr>
            @for ($i = 0; $i < $columns; $i++)
                <td class="px-4 py-3">
                    <div class="h-6 w-14 rounded-lg bg-gray-200"></div>
                </td>
            @endfor
        </tr>
    @endfor
</tbody>
