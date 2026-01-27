@extends('layouts.app')

@section('title', 'Data Peserta')

@section('content')
<x-breadcrumb />

<x-section-header title="Data Peserta Keseluruhan" icon="📊">
    <div style="position: relative; width: 100%; max-width: 300px;">
        <input type="text" id="searchInput" class="form-input" placeholder="Cari nama peserta..." style="padding-left: 2.5rem; height: 44px; font-size: 0.9rem;">
        <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); opacity: 0.5;">🔍</span>
    </div>
</x-section-header>

<x-card>
    <div class="table-responsive">
        <table id="participantTable">
            <thead>
                <tr>
                    <th>Peserta</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $participant)
                <tr>
                    <td>
                        <div class="user-name">{{ $participant->name }}</div>
                        <div class="user-region">{{ $participant->region->name ?? '-' }} • {{ $participant->category->name ?? '-' }}</div>
                    </td>
                    <td>
                        @if($participant->latestPayment && $participant->latestPayment->status == 'lunas')
                            <span class="badge badge-success">✓ Lunas</span>
                        @else
                            <span class="badge badge-danger">✗ Belum</span>
                        @endif
                    </td>
                </tr>
                @empty
                <x-empty-row :colspan="2">
                    Tidak ada data peserta
                </x-empty-row>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#participantTable tbody tr');
    
    rows.forEach(row => {
        let name = row.querySelector('.user-name').textContent.toLowerCase();
        let region = row.querySelector('.user-region').textContent.toLowerCase();
        
        if (name.includes(filter) || region.includes(filter)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
</script>
@endsection