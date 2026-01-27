@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="section-header fade-in">
    <h2>Detail Kategori</h2>
</div>

<div class="section-card fade-in">
    <h3 class="section-title-alt">🏷️ Informasi Kategori</h3>
    <form method="POST" action="{{ route('kategori.update', $category->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ $category->name }}" required>
        </div>
        <div class="form-group">
            <label for="price">Biaya Pendaftaran</label>
            <input type="number" id="price" name="price" class="form-input" value="{{ $category->price }}" step="0.01" min="0" required>
        </div>
        <div class="flex-actions">
            <button type="submit" class="btn-primary" style="flex: 1;">Update Kategori</button>
            <button type="button" class="btn-primary" style="flex: 1; background: var(--text-muted);" onclick="downloadCategoryPDF({{ $category->id }})">Export PDF</button>
        </div>
    </form>
</div>

<div class="section-header mt-4">
    <h2>Peserta di Kategori {{ $category->name }}</h2>
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
                        <div style="font-size:0.75rem; color:var(--text-muted);">{{ $participant->region->name ?? '-' }}</div>
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
                    <td colspan="2" class="text-center p-4">Belum ada peserta di kategori ini</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 fade-in">
    <form method="POST" action="{{ route('kategori.destroy', $category->id) }}" onsubmit="return confirm('Hapus kategori ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-primary w-full" style="background: var(--danger);">Hapus Kategori</button>
    </form>
</div>

<script>
function downloadCategoryPDF(categoryId) {
    window.location.href = `/pdf/category/${categoryId}`;
}
</script>
@endsection
