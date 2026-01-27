@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<x-section-header title="Tambah Kategori Baru" icon="🏷️" />

<x-card>
    <form method="POST" action="{{ route('kategori.store') }}">
        @csrf
        
        <x-input 
            id="name" 
            name="name" 
            type="text"
            label="Nama Kategori"
            placeholder="Contoh: Santri, Wali Santri, VIP, dll."
            :required="true"
            value="{{ old('name') }}">
        </x-input>

        <x-input 
            id="price" 
            name="price" 
            type="number"
            label="Biaya Pendaftaran (Rp)"
            placeholder="Contoh: 150000"
            :required="true"
            value="{{ old('price') }}"
            helper="Masukkan nominal biaya tanpa separator (contoh: 150000)">
        </x-input>

        <x-button buttonType="submit" block>
            ➕ Buat Kategori Baru
        </x-button>
    </form>
</x-card>

<x-section-header title="Daftar Kategori" icon="📋" />

<x-card>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Biaya</th>
                    <th>Peserta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td style="font-weight:700;">{{ $category->name }}</td>
                    <td style="font-weight: 700;">
                        <span style="color: var(--primary);">Rp {{ number_format($category->price, 0, ',', '.') }}</span>
                    </td>
                    <td style="color:var(--text-muted); font-size:0.85rem;">{{ $category->participants_count ?? 0 }} orang</td>
                    <td>
                        <a href="{{ route('detail.kategori', $category->id) }}" class="btn-icon-only" style="background:var(--primary-light); color: var(--primary);">✏️</a>
                    </td>
                </tr>
                @empty
                <x-empty-row :colspan="4">
                    Belum ada kategori yang terdaftar
                </x-empty-row>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection
