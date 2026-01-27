@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<x-section-header title="Pengaturan Sistem" icon="⚙️" />

<x-card title="⚙️ Konfigurasi Aplikasi" icon="">
    <form method="POST" action="{{ route('pengaturan') }}">
        @csrf
        
        <x-input 
            id="title_text" 
            name="title_text" 
            type="text"
            label="Nama Aplikasi"
            placeholder="Contoh: PPMHA"
            value="{{ $titleText ? $titleText->value : 'PPMHA' }}">
        </x-input>

        <x-input 
            id="subtitle_text" 
            name="subtitle_text" 
            type="text"
            label="Sub Judul Aplikasi"
            placeholder="Contoh: Manajemen Peserta"
            value="{{ $subtitleText ? $subtitleText->value : 'Manajemen Peserta' }}">
        </x-input>

        <x-textarea 
            id="greeting_text" 
            name="greeting_text" 
            label="Pesan Sapaan Dashboard"
            placeholder="Teks penyemangat🔥"
            rows="2">{{ $greetingText ? $greetingText->value : 'Selamat datang di aplikasi PPMHA.' }}</x-textarea>

        <x-input 
            id="whatsapp_number" 
            name="whatsapp_number" 
            type="text"
            label="Nomor WhatsApp Admin"
            helper="Format: 62812345678 (tanpa +, spasi, atau dash)"
            placeholder="628123456789"
            value="{{ $whatsappNumber ? $whatsappNumber->value : '628123456789' }}">
        </x-input>

        <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--border);">

        <h3 class="section-title-alt">📱 Template WhatsApp</h3>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">
            Buatlah laporan yang lebih menarik.
        </p>

        <x-input 
            id="wa_header" 
            name="wa_header" 
            type="text"
            label="Header Laporan"
            placeholder="Contoh: 📋 LAPORAN PESERTA"
            value="{{ $waHeader->value ?? '' }}">
        </x-input>

        <x-textarea 
            id="wa_schedule" 
            name="wa_schedule" 
            label="Jadwal pemberangkatan"
            placeholder="Masukkan jadwal pemberangkatan"
            rows="4">{{ $waSchedule->value ?? '' }}</x-textarea>

        <x-textarea 
            id="wa_departure" 
            name="wa_departure" 
            label="Waktu & Tempat berkumpul"
            placeholder="Masukkan waktu dan tempat"
            rows="3">{{ $waDeparture->value ?? '' }}</x-textarea>

        <div class="grid-2">
            <x-textarea 
                id="wa_fees" 
                name="wa_fees" 
                label="Rincian Biaya"
                placeholder="Masukkan rincian biaya"
                rows="3">{{ $waFees->value ?? '' }}</x-textarea>

            <x-textarea 
                id="wa_himbauan" 
                name="wa_himbauan" 
                label="Himbauan / Catatan"
                placeholder="Masukkan himbauan penting"
                rows="3">{{ $waHimbauan->value ?? '' }}</x-textarea>
        </div>

        <x-textarea 
            id="wa_bank_info" 
            name="wa_bank_info" 
            label="Informasi Rekening"
            placeholder="Masukkan info rekening bank"
            rows="3">{{ $waBankInfo->value ?? '' }}</x-textarea>

        <x-textarea 
            id="wa_contacts" 
            name="wa_contacts" 
            label="Kontak Konfirmasi"
            placeholder="Masukkan kontak konfirmasi"
            rows="3">{{ $waContacts->value ?? '' }}</x-textarea>

        <x-button buttonType="submit" block style="margin-top: 2rem;">
            💾 Terapkan Perubahan
        </x-button>
    </form>
</x-card>

<x-card>
    <div class="flex-actions">
        <form method="POST" action="{{ route('pengaturan') }}" style="flex: 1;">
            @csrf
            <input type="hidden" name="restore_default" value="1">
            <x-button buttonType="submit" style="width: 100%; background: var(--warning);" onclick="return confirm('Kembalikan ke pengaturan default? Semua perubahan akan hilang.')">
                🔄 Reset Default
            </x-button>
        </form>
        <a href="{{ route('dashboard.admin') }}" class="btn-primary" style="flex: 1; background: var(--text-muted); text-align: center;">
            ← Kembali
        </a>
    </div>
</x-card>
@endsection
