@extends('layouts.app')

@section('title', 'Detail Daerah')

@section('content')
<div class="section-header fade-in">
    <h2>Detail Daerah</h2>
</div>

<div class="section-card fade-in">
    <h3 class="section-title-alt">🌍 Informasi Wilayah</h3>
    <form method="POST" action="{{ route('daerah.update', $region->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Daerah</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ $region->name }}" required>
        </div>
        <div class="flex-actions">
            <button type="submit" class="btn-primary" style="flex: 1;">Update Nama</button>
            <button type="button" class="btn-primary" style="flex: 1; background: var(--text-muted);" onclick="downloadRegionPDF({{ $region->id }})">Export PDF</button>
        </div>
    </form>
</div>

<div class="section-header mt-4">
    <h2>Daftar Peserta di {{ $region->name }}</h2>
</div>

<div class="data-card fade-in">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Peserta</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $participant)
                <tr>
                    <td>
                        <div style="font-weight:700;">{{ $participant->name }}</div>
                        <div style="font-size:0.75rem; color:var(--text-muted);">{{ $participant->category->name ?? '-' }}</div>
                    </td>
                    <td>
                        @if($participant->latestPayment && $participant->latestPayment->status == 'lunas')
                            <span class="badge badge-success">Lunas</span>
                        @else
                            <span class="badge badge-danger">Belum</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                @if($participants->isEmpty())
                <tr>
                    <td colspan="2" class="text-center p-4">Belum ada peserta di daerah ini</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 fade-in">
    <form method="POST" action="{{ route('daerah.destroy', $region->id) }}" onsubmit="return confirm('Hapus daerah ini? Semua data terkait mungkin terpengaruh.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-primary w-full" style="background: var(--danger);">Hapus Daerah</button>
    </form>
</div>

<script>
function downloadRegionPDF(regionId) {
    window.location.href = `/pdf/region/${regionId}`;
}
</script>
@endsection
