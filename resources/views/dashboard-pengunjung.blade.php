@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="stats-slider fade-in">
    <div class="stat-card">
        <div class="stat-icon-bg">👥</div>
        <span class="stat-number">{{ $participants->count() }}</span>
        <span class="stat-label">Total Peserta</span>
    </div>
    <div class="stat-card">
        <div class="stat-icon-bg">✅</div>
        <span class="stat-number">{{ $participants->filter(fn($p) => $p->latestPayment && $p->latestPayment->status == 'lunas')->count() }}</span>
        <span class="stat-label">Sudah Lunas</span>
    </div>
</div>

<x-section-header title="Daftar Peserta Keseluruhan" icon="📋" />

<x-card>
    <div class="table-responsive">
        <table>
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
                    Belum ada data peserta
                </x-empty-row>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection
