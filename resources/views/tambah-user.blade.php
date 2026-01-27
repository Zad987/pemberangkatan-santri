@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<x-section-header title="Tambah User Baru" icon="👤" />

<x-card class="fade-in">
    <form method="POST" action="{{ route('user.store') }}">
        @csrf
        
        <x-input
            id="name"
            name="name"
            type="text"
            label="Nama User"
            placeholder="Contoh: Koordinator Jejeg"
            :required="true"
            value="{{ old('name') }}"
            :error="$errors->first('name')">
        </x-input>

        <x-select
            id="role"
            name="role"
            label="Role / Peran"
            :required="true"
            :options="['induk' => '🔐 Admin Induk', 'daerah' => '🌍 Perwakilan Daerah', 'umum' => '👁️ Umum/Pengunjung']"
            value="{{ old('role') }}"
            onchange="toggleRegionField()"
            :error="$errors->first('role')">
        </x-select>

        <x-select
            id="region_id"
            name="region_id"
            label="Penugasan Daerah"
            :options="$regions->pluck('name', 'id')->toArray()"
            value="{{ old('region_id') }}"
            :error="$errors->first('region_id')">
        </x-select>

        <div class="grid-2">
            <x-input
                id="password"
                name="password"
                type="password"
                label="Password"
                placeholder="••••••••"
                :required="true"
                :error="$errors->first('password')">
            </x-input>

            <x-input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                label="Konfirmasi Password"
                placeholder="••••••••"
                :required="true"
                :error="$errors->first('password_confirmation')">
            </x-input>
        </div>

        <x-button buttonType="submit" block>
            ➕ Tambah User Baru
        </x-button>
    </form>
</x-card>

<x-section-header title="Daftar User Sistem" icon="👥" />

<x-card class="fade-in">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-username">{{ $user->username }}</div>
                        @if($user->region)
                            <div class="user-region">{{ $user->region->name }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $user->role == 'induk' ? 'badge-success' : ($user->role == 'daerah' ? 'badge-info' : 'badge-secondary') }}">
                            {{ $user->role == 'induk' ? '🔐 Admin' : ($user->role == 'daerah' ? '🌍 Daerah' : '👁️ Umum') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('detail.user', $user->id) }}" class="btn-icon-only">✏️</a>
                    </td>
                </tr>
                @empty
                <x-empty-row :colspan="3">
                    Belum ada user yang terdaftar
                </x-empty-row>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>

<script>
function toggleRegionField() {
    const roleSelect = document.getElementById('role');
    const regionSelect = document.getElementById('region_id');

    if (roleSelect.value === 'daerah') {
        regionSelect.required = true;
        regionSelect.disabled = false;
    } else {
        regionSelect.required = false;
        regionSelect.disabled = true;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', toggleRegionField);
</script>

@endsection
