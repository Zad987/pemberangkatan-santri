@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<x-breadcrumb />

<!-- Primary Actions Section -->
<x-section-header title="Dashboard Admin" icon="📊">
    <div class="dashboard-actions">
        <button onclick="shareToWA()" class="btn-secondary" style="display: flex; align-items: center; gap: 0.5rem;">
            <span>📱</span>
            <span>Share WA</span>
        </button>
        <button onclick="showPdfDialog()" class="btn-secondary" style="display: flex; align-items: center; gap: 0.5rem;">
            <span>📄</span>
            <span>Ekspor PDF</span>
        </button>
    </div>
</x-section-header>

<!-- Key Metrics Overview -->
<div class="dashboard-section">
    <h2 class="section-title">📈 Ringkasan Utama</h2>
    <div class="stats-grid">
        <div class="metric-card primary">
            <div class="metric-icon">👥</div>
            <div class="metric-content">
                <span class="metric-number">{{ $totalParticipants }}</span>
                <span class="metric-label">Total Peserta</span>
            </div>
        </div>
        <div class="metric-card success">
            <div class="metric-icon">✅</div>
            <div class="metric-content">
                <span class="metric-number">{{ $paidParticipants }}</span>
                <span class="metric-label">Lunas</span>
            </div>
        </div>
        <div class="metric-card warning">
            <div class="metric-icon">⏳</div>
            <div class="metric-content">
                <span class="metric-number">{{ $unpaidParticipants }}</span>
                <span class="metric-label">Belum Bayar</span>
            </div>
        </div>
        <div class="metric-card info">
            <div class="metric-icon">💰</div>
            <div class="metric-content">
                <span class="metric-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                <span class="metric-label">Total Pendapatan</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Management Actions -->
<div class="dashboard-section">
    <h2 class="section-title">⚡ Aksi Cepat</h2>
    <div class="quick-actions-grid">
        <a href="{{ route('tambah.user') }}" class="action-card">
            <span class="action-icon">👥</span>
            <span class="action-label">Tambah User</span>
        </a>
        <a href="{{ route('tambah.daerah') }}" class="action-card">
            <span class="action-icon">🌍</span>
            <span class="action-label">Tambah Daerah</span>
        </a>
        <a href="{{ route('tambah.kategori') }}" class="action-card">
            <span class="action-icon">🏷️</span>
            <span class="action-label">Kategori</span>
        </a>
    </div>
</div>

<!-- Analytics & Recent Activity -->
<div class="dashboard-section">
    <h2 class="section-title">📊 Analitik & Aktivitas</h2>
    <div class="analytics-grid">
        <x-card title="📊 Statistik Pembayaran">
            <div style="height: 120px;">
                <canvas id="paymentChart"></canvas>
            </div>
        </x-card>
        <x-card title="🆕 Peserta Terbaru">
            <div class="latest-list">
                @forelse($latestParticipants as $p)
                    <div class="latest-item">
                        <div class="latest-avatar">
                            {{ substr($p->name, 0, 1) }}
                        </div>
                        <div class="latest-info">
                            <div class="latest-name">{{ $p->name }}</div>
                            <div class="latest-meta">{{ $p->region->name ?? '-' }} • {{ $p->created_at->diffForHumans() }}</div>
                        </div>
                        <a href="{{ route('detail.peserta', $p->id) }}" class="btn-icon-only" style="width: 32px; height: 32px; font-size: 0.8rem;">➡️</a>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">Belum ada peserta baru</div>
                @endforelse
            </div>
        </x-card>
    </div>
</div>

<!-- Regional Data -->
<div class="dashboard-section">
    <x-section-header title="Data Peserta per Wilayah" icon="🌍">
        <a href="{{ route('keseluruhan.peserta') }}" class="btn-icon-only">📋</a>
    </x-section-header>
    
    <x-card>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Daerah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participantsByRegion as $region)
                    <tr>
                        <td style="font-weight:700;">{{ $region->name }}</td>
                        <td style="color:var(--text-muted); font-size:0.8rem;">{{ $region->participants_count }} Peserta</td>
                        <td>
                            <span class="badge badge-success">{{ $region->paid_count ?? 0 }} Lunas</span>
                        </td>
                    </tr>
                    @empty
                    <x-empty-row :colspan="3">
                        Belum ada data region peserta
                    </x-empty-row>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</div>

<!-- Secondary Actions -->
<div class="dashboard-section">
    <div class="secondary-actions">
        <x-button type="success" style="flex: 1;" onclick="shareToWA()">
            📤 Share ke WhatsApp
        </x-button>
        <x-button type="secondary" style="flex: 1;" onclick="showPdfDialog()">
            📥 Export PDF
        </x-button>
    </div>
</div>

<!-- PDF Sort Dialog -->
<div id="pdfDialog" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; padding: 30px; max-width: 400px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <h2 style="margin: 0 0 20px 0; color: var(--primary);">📊 Pilih Format Laporan</h2>
        <p style="margin: 0 0 20px 0; color: #666;">Laporan akan diurutkan berdasarkan pilihan Anda</p>
        
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <button type="button" class="btn-primary" style="width: 100%;" onclick="downloadPDFWithSort('category')">
                🏷️ Urut berdasarkan Kategori
            </button>
            <button type="button" class="btn-primary" style="width: 100%;" onclick="downloadPDFWithSort('region')">
                🌍 Urut berdasarkan Daerah
            </button>
            <button type="button" class="btn-primary" style="width: 100%; background: #666; margin-top: 10px;" onclick="closePdfDialog()">
                ✕ Batal
            </button>
        </div>
    </div>
</div>

{{-- Hidden divs to pass PHP data to JavaScript --}}
<div id="chartData" 
     data-paid="{{ $paidParticipants }}"
     data-unpaid="{{ $unpaidParticipants }}"
     data-category-labels="{{ json_encode($participantsByCategory->pluck('name')->toArray()) }}"
     data-category-data="{{ json_encode($participantsByCategory->pluck('participants_count')->toArray()) }}"
     style="display: none;"></div>

<script>
// PDF Dialog Functions
function showPdfDialog() {
    document.getElementById('pdfDialog').style.display = 'flex';
}

function closePdfDialog() {
    document.getElementById('pdfDialog').style.display = 'none';
}

function downloadPDFWithSort(sortBy) {
    closePdfDialog();
    window.location.href = "{{ route('pdf.admin.report') }}?sortBy=" + sortBy;
}

// WhatsApp Share Function
function shareToWA() {
    fetch("{{ route('admin.share.whatsapp') }}")
        .then(response => response.json())
        .then(data => {
            window.open(data.url, '_blank');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat membagikan ke WhatsApp');
        });
}

// Close dialog when clicking outside
document.addEventListener('click', function(event) {
    const dialog = document.getElementById('pdfDialog');
    if (event.target === dialog) {
        closePdfDialog();
    }
});

// Charts Implementation
document.addEventListener('DOMContentLoaded', function() {
    // Get data from hidden div
    const chartData = document.getElementById('chartData');
    const paidParticipants = parseInt(chartData.getAttribute('data-paid'));
    const unpaidParticipants = parseInt(chartData.getAttribute('data-unpaid'));
    const categoryLabels = JSON.parse(chartData.getAttribute('data-category-labels'));
    const categoryData = JSON.parse(chartData.getAttribute('data-category-data'));
    
    // Payment Chart
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Lunas', 'Belum Bayar'],
            datasets: [{
                data: [paidParticipants, unpaidParticipants],
                backgroundColor: ['#10b981', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { weight: 'bold' }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Jumlah Peserta',
                data: categoryData,
                backgroundColor: '#059669',
                borderRadius: 8,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { display: false }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>

@endsection
