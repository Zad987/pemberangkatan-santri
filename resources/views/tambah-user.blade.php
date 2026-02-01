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
    const roleValue = document.getElementById('role').value;
    const regionDropdown = document.querySelector('[data-dropdown-id="region_id"]');

    if (roleValue === 'daerah') {
        regionDropdown.classList.remove('disabled');
        document.getElementById('region_id').required = true;
    } else {
        regionDropdown.classList.add('disabled');
        document.getElementById('region_id').required = false;
        document.getElementById('region_id').value = '';
        // Reset display text
        const selectedText = regionDropdown.querySelector('.selected-text');
        if (selectedText) {
            selectedText.textContent = 'Pilih opsi...';
        }
        // Remove selected state
        const options = regionDropdown.querySelectorAll('.dropdown-option');
        options.forEach(option => option.classList.remove('selected'));
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleRegionField();

    // Listen for changes on the role dropdown
    document.getElementById('role').addEventListener('change', toggleRegionField);

    // Initialize custom dropdowns
    document.querySelectorAll('.custom-dropdown').forEach(function(dropdown) {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const options = dropdown.querySelector('.dropdown-options');
        const hiddenInput = document.getElementById(dropdown.dataset.dropdownId);
        const selectedText = dropdown.querySelector('.selected-text');

        if (!trigger || !options || !hiddenInput || !selectedText) return;

        // Toggle dropdown on click
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (dropdown.classList.contains('disabled')) return;

            // Close other dropdowns
            document.querySelectorAll('.custom-dropdown.open').forEach(function(openDropdown) {
                if (openDropdown !== dropdown) {
                    openDropdown.classList.remove('open');
                }
            });

            dropdown.classList.toggle('open');
        });

        // Handle keyboard navigation
        trigger.addEventListener('keydown', function(e) {
            if (dropdown.classList.contains('disabled')) return;

            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                dropdown.classList.toggle('open');
            } else if (e.key === 'Escape') {
                dropdown.classList.remove('open');
            } else if (e.key === 'ArrowDown' && dropdown.classList.contains('open')) {
                e.preventDefault();
                const firstOption = options.querySelector('.dropdown-option');
                if (firstOption) firstOption.focus();
            }
        });

        // Handle option selection
        options.addEventListener('click', function(e) {
            if (e.target.classList.contains('dropdown-option')) {
                e.stopPropagation();
                const value = e.target.dataset.value;
                const text = e.target.textContent.trim();

                // Update hidden input
                hiddenInput.value = value;

                // Update display text
                selectedText.textContent = text;

                // Update selected state
                options.querySelectorAll('.dropdown-option').forEach(function(option) {
                    option.classList.remove('selected');
                });
                e.target.classList.add('selected');

                // Close dropdown
                dropdown.classList.remove('open');

                // Trigger change event
                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });

        // Handle keyboard selection
        options.addEventListener('keydown', function(e) {
            const currentOption = document.activeElement;
            if (!currentOption.classList.contains('dropdown-option')) return;

            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                currentOption.click();
            } else if (e.key === 'Escape') {
                dropdown.classList.remove('open');
                trigger.focus();
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                const nextOption = currentOption.nextElementSibling;
                if (nextOption) nextOption.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prevOption = currentOption.previousElementSibling;
                if (prevOption) {
                    prevOption.focus();
                } else {
                    trigger.focus();
                }
            }
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.custom-dropdown')) {
            document.querySelectorAll('.custom-dropdown.open').forEach(function(openDropdown) {
                openDropdown.classList.remove('open');
            });
        }
    });
});
</script>

@endsection
