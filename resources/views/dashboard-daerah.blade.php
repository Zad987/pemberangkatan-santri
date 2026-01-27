@extends('layouts.app')

@section('title', 'Dashboard Daerah')

@section('content')
<div class="stats-slider fade-in">
    <div class="stat-card">
        <div class="stat-icon-bg">👥</div>
        <span class="stat-number">{{ $regionParticipants->count() }}</span>
        <span class="stat-label">Total Peserta</span>
    </div>
    <div class="stat-card">
        <div class="stat-icon-bg">✅</div>
        <span class="stat-number">{{ $regionParticipants->filter(fn($p) => $p->is_paid)->count() }}</span>
        <span class="stat-label">Sudah Lunas</span>
    </div>
    <div class="stat-card">
        <div class="stat-icon-bg">⌛</div>
        <span class="stat-number">{{ $regionParticipants->filter(fn($p) => !$p->is_paid)->count() }}</span>
        <span class="stat-label">Belum Lunas</span>
    </div>
</div>

<div class="grid-2 fade-in">
    <x-card title="➕ Tambah Peserta Baru">
        <form method="POST" action="{{ route('tambah.peserta') }}">
            @csrf
            <input type="hidden" name="region_id" value="{{ auth()->user()->region_id }}">

            <x-input 
                id="name" 
                name="name" 
                type="text"
                label="Nama Lengkap"
                placeholder="Contoh: Ahmad Ibnu Sina"
                :required="true">
            </x-input>

            <x-select 
                id="category_id" 
                name="category_id" 
                label="Kategori"
                :required="true"
                :options="$categories->pluck('name', 'id')->toArray()">
            </x-select>

            <x-button buttonType="submit" block>
                ✅ Tambah Peserta
            </x-button>
        </form>
    </x-card>
</div>

<x-section-header title="Daftar Peserta Saya" icon="👥" />

<x-card>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama & Kategori</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($regionParticipants as $participant)
                <tr data-href="{{ route('detail.peserta', $participant->id) }}">
                    <td>
                        <div class="user-name {{ $participant->is_paid ? 'text-success' : 'text-danger' }}">
                            {{ $participant->name }}
                        </div>
                        <div class="user-region">{{ $participant->category->name ?? '-' }}</div>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('detail.peserta', $participant->id) }}" class="btn-primary btn-sm">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <x-empty-row :colspan="2">
                    Belum ada peserta yang terdaftar
                </x-empty-row>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection
