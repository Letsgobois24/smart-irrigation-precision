@props(['columns', 'rows', 'tdClass' => ''])
<tbody {{ $attributes }} wire:loading.class.remove="hidden" wire:loading.class="table-row-group">
    @for ($row = 0; $row < $rows; $row++)
        <tr>
            @for ($i = 0; $i < $columns - 1; $i++)
                <td class="px-4 py-3 {{ $tdClass }}">
                    <div class="h-6 w-14 rounded-lg bg-gray-200 m-auto"></div>
                </td>
            @endfor
            <td class="px-4 py-3">
                <div class="h-6 w-14 rounded-lg bg-gray-200 m-auto"></div>
            </td>
        </tr>
    @endfor
</tbody>
