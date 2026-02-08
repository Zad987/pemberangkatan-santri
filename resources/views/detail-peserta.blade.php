@extends('layouts.app')

@section('title', 'Detail Peserta - ' . $participant->name)

@section('content')
<x-section-header title="👤 Detail Peserta" icon="👤" />

<x-card>
    <div class="detail-header">
        <h2 style="margin: 0 0 0.5rem 0; font-size: 1.5rem; font-weight: 700; color: var(--text-main);">
            {{ $participant->name }}
        </h2>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; font-size: 0.9rem; color: var(--text-muted);">
            <span style="display: flex; align-items: center; gap: 0.5rem;">
                📍 {{ $participant->region->name ?? 'Wilayah tidak ditemukan' }}
            </span>
            <span style="display: flex; align-items: center; gap: 0.5rem;">
                🏷️ {{ $participant->category->name ?? 'Kategori tidak ditemukan' }}
            </span>
        </div>
    </div>

    <div class="mb-4">
        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">
            <span>Progress Pembayaran</span>
            <span id="payment-progress-percent">{{ round($paymentProgress) }}%</span>
        </div>
        <div style="height: 12px; background: var(--bg-accent); border-radius: 10px; overflow: hidden; border: 1px solid var(--border-light);">
            <div id="payment-progress-bar" style="height: 100%; background: var(--gradient-success); transition: width 0.5s ease;"></div>
        </div>
    </div>

    <div class="detail-info-grid">
        <div class="info-item">
            <span class="info-label">Biaya Pendaftaran</span>
            <div class="info-value">Rp {{ number_format($categoryPrice, 0, ',', '.') }}</div>
        </div>
        <div class="grid-2">
            <div class="info-item">
                <span class="info-label">Total Bayar</span>
                <div class="info-value text-success">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
            </div>
            <div class="info-item">
                <span class="info-label">Sisa Pembayaran</span>
                <div class="info-value {{ $isFullyPaid ? 'text-success' : 'text-danger' }}">
                    @if($isFullyPaid)
                        ✓ Lunas
                    @else
                        Rp {{ number_format($remainingBalance, 0, ',', '.') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(!$isFullyPaid)
        <div style="background: rgba(217, 119, 6, 0.05); border-left: 4px solid var(--warning); padding: 1rem; border-radius: 8px; margin-top: 1rem;">
            <span style="color: var(--warning); font-weight: 700;">⚠️ Pembayaran Belum Lengkap</span>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Peserta masih memiliki sisa pembayaran yang harus diselesaikan.</p>
        </div>
    @else
        <div style="background: rgba(5, 150, 105, 0.05); border-left: 4px solid var(--success); padding: 1rem; border-radius: 8px; margin-top: 1rem;">
            <span style="color: var(--success); font-weight: 700;">✓ Pembayaran Lengkap</span>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Peserta telah menyelesaikan semua pembayaran.</p>
        </div>
    @endif
</x-card>

<x-card title="📝 Update Pembayaran">
    <form method="POST" action="{{ route('update.payment', $participant->id) }}" id="paymentForm">
        @csrf
        @method('PUT')
        
        @if($errors->has('amount'))
            <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid var(--danger); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <span style="color: var(--danger); font-weight: 700;">❌ Kesalahan Pembayaran</span>
                <p style="color: var(--text-main); font-size: 0.9rem; margin-top: 0.5rem;">{{ $errors->first('amount') }}</p>
            </div>
        @endif

        @if($isFullyPaid)
            <div style="background: rgba(5, 150, 105, 0.1); border-left: 4px solid var(--success); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <span style="color: var(--success); font-weight: 700;">✓ Peserta Sudah Lunas</span>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Peserta telah menyelesaikan semua pembayaran dan tidak dapat menambah pembayaran baru.</p>
            </div>
            <x-button buttonType="button" block style="background: var(--border); color: var(--text-muted);" disabled>
                💾 Peserta Sudah Lunas (Tidak Bisa Diubah)
            </x-button>
        @else
            <x-input 
                id="amount" 
                name="amount" 
                type="number"
                label="Jumlah Bayar Baru (Rp)"
                placeholder="0"
                step="1000"
                min="0"
                :required="true"
                :value="old('amount')"
                oninput="calculateRemaining(this.value)">
            </x-input>

            <div id="remaining-feedback" style="display: none; background: var(--primary-light); padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px dashed var(--primary);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--primary-dark);">Sisa Setelah Bayar:</span>
                    <span id="new-remaining" style="font-size: 1.1rem; font-weight: 900; color: var(--primary);">Rp 0</span>
                </div>
            </div>

            <div style="background: rgba(59, 130, 246, 0.05); border-left: 4px solid var(--primary); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                    <strong>Limit Pembayaran:</strong> Rp {{ number_format($remainingBalance, 0, ',', '.') }}
                </div>
            </div>

            <x-input 
                id="payment_date" 
                name="payment_date" 
                type="date"
                label="Tanggal Pembayaran"
                :required="true"
                :value="old('payment_date', date('Y-m-d'))">
            </x-input>

            <x-textarea 
                id="notes" 
                name="notes" 
                label="Catatan (Opsional)"
                placeholder="Tambahkan catatan pembayaran (contoh: Transfer BRI, Via Cash, dll)"
                rows="2">{{ old('notes') }}</x-textarea>

            <x-button buttonType="submit" block id="submitPaymentBtn">
                💰 Proses Pembayaran
            </x-button>
        @endif
    </form>
</x-card>

<x-section-header title="Riwayat Pembayaran" icon="&#128221;" />

<x-card>
    @forelse($participant->payments as $payment)
    <div class="payment-item">
        <div class="payment-meta">
            <div class="payment-date">{{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d M Y') }}</div>
            <div class="payment-amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
        </div>
        <div class="payment-body">
            <span class="badge {{ $payment->status == 'lunas' ? 'badge-success' : 'badge-warning' }}">
                {{ $payment->status == 'lunas' ? '✓ Lunas' : '⏳ Menunggu' }}
            </span>
            <span class="payment-notes">{{ $payment->notes ?: 'Tidak ada catatan' }}</span>
        </div>
        <div class="payment-actions">
            <form method="POST" action="{{ route('payment.destroy', $payment->id) }}" onsubmit="return confirmDelete(event, this)">
                @csrf
                @method('DELETE')
                <x-button buttonType="submit" class="delete-payment-btn" style="background: var(--danger); padding: 0.35rem 0.75rem; font-size: 0.85rem;">
                    🗑️ Hapus
                </x-button>
            </form>
        </div>
    </div>
    @empty
        <div class="empty-payments">Belum ada riwayat pembayaran</div>
    @endforelse
</x-card>

<div class="mt-4 fade-in flex-actions">
    <a href="{{ route('peserta.edit', $participant->id) }}" class="btn-primary" style="flex: 1; background: var(--warning);">
        ✏️ Edit Profil
    </a>
    <form method="POST" action="{{ route('peserta.destroy', $participant->id) }}" style="flex: 1;" onsubmit="return confirmDeleteParticipant(event, this)">
        @csrf
        @method('DELETE')
        <x-button buttonType="submit" style="width: 100%; background: var(--danger);">
            🗑️ Hapus Peserta
        </x-button>
    </form>
</div>

{{-- Hidden div to pass PHP data to JavaScript --}}
<div id="detailData" 
     data-payment-progress="{{ $paymentProgress }}"
     data-remaining-balance="{{ $remainingBalance }}"
     style="display: none;"></div>

<style>
/* Loading spinner styles */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
      to { transform: rotate(360deg); }
  }
  
  .btn-loading {
      position: relative;
      pointer-events: none;
  }

.btn-loading .btn-text {
    visibility: hidden;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-top: -8px;
    margin-left: -8px;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Payment history cards */
.payment-item {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 0.5rem 1rem;
    padding: 1rem;
    border: 1px solid var(--border-light);
    border-radius: 12px;
    background: var(--bg-secondary);
    margin-bottom: 0.75rem;
    box-shadow: var(--shadow-sm);
}
.payment-meta {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}
.payment-date {
    font-weight: 700;
    color: var(--text-main);
}
.payment-amount {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--primary);
}
.payment-body {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}
.payment-notes {
    color: var(--text-muted);
    font-size: 0.9rem;
}
.payment-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
.empty-payments {
    text-align: center;
    padding: 1rem;
    color: var(--text-muted);
}
</style>

<script>
    function calculateRemaining(value) {
        const currentRemaining = Number(document.getElementById('detailData').getAttribute('data-remaining-balance'));
        const amount = parseFloat(value) || 0;
        const feedback = document.getElementById('remaining-feedback');
        const display = document.getElementById('new-remaining');
        
        if (amount > 0) {
            feedback.style.display = 'block';
            const newRemaining = Math.max(0, currentRemaining - amount);
            display.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(newRemaining);
            
            if (amount > currentRemaining) {
                display.style.color = 'var(--danger)';
                feedback.style.borderColor = 'var(--danger)';
                feedback.style.background = 'rgba(239, 68, 68, 0.1)';
            } else {
                display.style.color = 'var(--primary)';
                feedback.style.borderColor = 'var(--primary)';
                feedback.style.background = 'rgba(5, 150, 105, 0.1)';
            }
        } else {
            feedback.style.display = 'none';
        }
    }

    function confirmDelete(event, form) {
        event.preventDefault();
        if (confirm('Hapus pembayaran ini? Tindakan ini tidak dapat dibatalkan.')) {
            showLoading(form.querySelector('button'));
            form.submit();
        }
    }

    function confirmDeleteParticipant(event, form) {
        event.preventDefault();
        if (confirm('Hapus peserta ini beserta semua datanya? Tindakan ini tidak dapat dibatalkan.')) {
            showLoading(form.querySelector('button'));
            form.submit();
        }
    }

    function showLoading(button) {
        button.classList.add('btn-loading');
        button.disabled = true;
    }

    // Auto-clear form after successful submission
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (window.location.href.includes('/detail/peserta/')) {
            // Form akan otomatis refresh dari server jika berhasil
            const form = document.getElementById('paymentForm');
            if (form) {
                form.addEventListener('submit', function() {
                    showLoading(document.getElementById('submitPaymentBtn'));
                });
            }
        }
        
        // Set dynamic width for payment progress bar
        const detailData = document.getElementById('detailData');
        const paymentProgress = parseFloat(detailData.getAttribute('data-payment-progress'));
        const progressBar = document.getElementById('payment-progress-bar');
        const progressPercent = document.getElementById('payment-progress-percent');
        
        if (progressBar) {
            progressBar.style.width = paymentProgress + '%';
        }
        
        if (progressPercent) {
            progressPercent.textContent = Math.round(paymentProgress) + '%';
        }
    });
</script>

@endsection
