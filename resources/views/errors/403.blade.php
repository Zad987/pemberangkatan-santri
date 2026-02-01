@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
<div class="error-container fade-in">
    <div class="error-icon">🔒</div>
    <h1 class="error-title">Akses Terbatas</h1>
    <p class="error-message">Maaf, akun Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi admin jika ini adalah kesalahan.</p>

    <div class="flex-actions w-full" style="justify-content: center;">
        @auth
            <a href="{{ url()->previous() }}" class="btn-primary" style="background: var(--text-muted);">Kembali</a>
            <a href="{{ route('dashboard.' . (Auth::user()->role->value == 'induk' ? 'admin' : (Auth::user()->role->value == 'daerah' ? 'daerah' : 'pengunjung'))) }}" class="btn-primary">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn-primary">Halaman Login</a>
        @endauth
    </div>
</div>
@endsection
