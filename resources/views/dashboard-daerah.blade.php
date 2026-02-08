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

<script>
// Init custom dropdown component (same behaviour as halaman tambah user)
document.addEventListener('DOMContentLoaded', function() {
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
            document.querySelectorAll('.custom-dropdown.open').forEach(function(openDropdown) {
                if (openDropdown !== dropdown) openDropdown.classList.remove('open');
            });
            dropdown.classList.toggle('open');
        });

        // Keyboard support
        trigger.addEventListener('keydown', function(e) {
            if (dropdown.classList.contains('disabled')) return;
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault(); dropdown.classList.toggle('open');
            } else if (e.key === 'Escape') {
                dropdown.classList.remove('open');
            } else if (e.key === 'ArrowDown' && dropdown.classList.contains('open')) {
                e.preventDefault();
                const first = options.querySelector('.dropdown-option');
                if (first) first.focus();
            }
        });

        // Option click
        options.addEventListener('click', function(e) {
            if (!e.target.classList.contains('dropdown-option')) return;
            e.stopPropagation();
            const value = e.target.dataset.value;
            const text = e.target.textContent.trim();
            hiddenInput.value = value;
            selectedText.textContent = text;
            options.querySelectorAll('.dropdown-option').forEach(opt => opt.classList.remove('selected'));
            e.target.classList.add('selected');
            dropdown.classList.remove('open');
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
        });

        // Option keyboard nav
        options.addEventListener('keydown', function(e) {
            const current = document.activeElement;
            if (!current.classList.contains('dropdown-option')) return;
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault(); current.click();
            } else if (e.key === 'Escape') {
                dropdown.classList.remove('open'); trigger.focus();
            } else if (e.key === 'ArrowDown') {
                e.preventDefault(); const next = current.nextElementSibling; if (next) next.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault(); const prev = current.previousElementSibling; if (prev) prev.focus(); else trigger.focus();
            }
        });
    });

    // Close on outside click
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
