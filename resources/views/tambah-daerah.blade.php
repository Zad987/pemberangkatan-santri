@extends('layouts.app')

@section('title', 'Manajemen Daerah')

@section('content')
<x-section-header title="Tambah Daerah Baru" icon="🌍" />

<x-card>
    <form method="POST" action="{{ route('daerah.store') }}">
        @csrf
        
        <x-input 
            id="name" 
            name="name" 
            type="text"
            label="Nama Daerah"
            placeholder="Contoh: Jejeg, dll"
            :required="true"
            value="{{ old('name') }}">
        </x-input>

        <x-button buttonType="submit" block>
            ➕ Tambahkan Daerah
        </x-button>
    </form>
</x-card>

<x-section-header title="Daftar Daerah" icon="📍" />

<x-card>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Daerah</th>
                    <th>Peserta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($regions as $region)
                <tr>
                    <td style="font-weight:700;">{{ $region->name }}</td>
                    <td style="color:var(--text-muted); font-size:0.85rem;">{{ $region->participants_count ?? 0 }} peserta</td>
                    <td>
                        <a href="{{ route('detail.daerah', $region->id) }}" class="btn-icon-only" style="background:var(--primary-light); color: var(--primary);">✏️</a>
                    </td>
                </tr>
                @empty
                <x-empty-row :colspan="3">
                    Belum ada daerah yang terdaftar
                </x-empty-row>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection
