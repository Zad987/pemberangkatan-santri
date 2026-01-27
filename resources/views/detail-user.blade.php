@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="section-header fade-in">
    <h2>Manajemen User</h2>
</div>

<div class="section-card fade-in">
    <h3 class="section-title-alt">👤 Profil Pengguna</h3>
    <form method="POST" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name', $user->name) }}" required>
            @if($errors->has('name'))
                <small class="text-danger">{{ $errors->first('name') }}</small>
            @endif
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label for="role">Tipe Akun</label>
                <select id="role" name="role" class="form-input {{ $errors->has('role') ? 'is-invalid' : '' }}" required onchange="toggleRegionField()">
                    <option value="induk" {{ old('role', $user->role) == 'induk' ? 'selected' : '' }}>Admin</option>
                    <option value="daerah" {{ old('role', $user->role) == 'daerah' ? 'selected' : '' }}>Daerah</option>
                    <option value="umum" {{ old('role', $user->role) == 'umum' ? 'selected' : '' }}>Umum</option>
                </select>
                @if($errors->has('role'))
                    <small class="text-danger">{{ $errors->first('role') }}</small>
                @endif
            </div>
            <div class="form-group">
                <label for="region_id">Wilayah Tugas</label>
                <select id="region_id" name="region_id" class="form-input {{ $errors->has('region_id') ? 'is-invalid' : '' }}">
                    <option value="">Tidak Ada</option>
                    @foreach($regions as $region)
                    <option value="{{ $region->id }}" {{ old('region_id', $user->region_id) == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('region_id'))
                    <small class="text-danger">{{ $errors->first('region_id') }}</small>
                @endif
            </div>
        </div>
        <button type="submit" class="btn-primary w-full">Simpan Perubahan</button>
    </form>
</div>

<div class="section-card fade-in">
    <h3 class="section-title-alt">🔑 Keamanan</h3>
        <form method="POST" action="{{ route('user.password.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password" class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Min. 8 karakter" required>
            @if($errors->has('password'))
                <small class="text-danger">{{ $errors->first('password') }}</small>
            @endif
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" required>
            @if($errors->has('password_confirmation'))
                <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
            @endif
        </div>
        <button type="submit" class="btn-primary w-full" style="background: var(--text-main);">Ganti Password</button>
    </form>
</div>

<div class="section-card fade-in">
    <h3 class="section-title-alt">⚙️ Opsi Lanjutan</h3>
    <div class="flex-actions">
        <form method="POST" action="{{ route('user.logout.device', $user->id) }}" style="flex: 1;">
            @csrf
            <button type="submit" class="btn-primary w-full" style="background: var(--warning);">Reset Perangkat</button>
        </form>
        <form method="POST" action="{{ route('user.destroy', $user->id) }}" style="flex: 1;" onsubmit="return confirm('Hapus user ini selamanya?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-primary w-full" style="background: var(--danger);">Hapus User</button>
        </form>
    </div>
</div>

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
