@props([
    'colspan' => 2
])

<tr>
    <td colspan="{{ $colspan }}" class="text-center empty-state">
        <div class="empty-state-icon">📭</div>
        <div class="empty-state-text">{{ $slot ?? 'Tidak ada data' }}</div>
    </td>
</tr>
