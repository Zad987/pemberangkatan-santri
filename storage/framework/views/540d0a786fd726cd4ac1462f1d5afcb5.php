<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>

<!-- Primary Actions Section -->
<?php if (isset($component)) { $__componentOriginal436399e29d00ce6b8f47e38277d39536 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal436399e29d00ce6b8f47e38277d39536 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-header','data' => ['title' => 'Dashboard Admin','icon' => '📊']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard Admin','icon' => '📊']); ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal436399e29d00ce6b8f47e38277d39536)): ?>
<?php $attributes = $__attributesOriginal436399e29d00ce6b8f47e38277d39536; ?>
<?php unset($__attributesOriginal436399e29d00ce6b8f47e38277d39536); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal436399e29d00ce6b8f47e38277d39536)): ?>
<?php $component = $__componentOriginal436399e29d00ce6b8f47e38277d39536; ?>
<?php unset($__componentOriginal436399e29d00ce6b8f47e38277d39536); ?>
<?php endif; ?>

<!-- Key Metrics Overview -->
<div class="dashboard-section">
    <h2 class="section-title">📈 Ringkasan Utama</h2>
    <div class="stats-grid">
        <div class="metric-card primary">
            <div class="metric-icon">👥</div>
            <div class="metric-content">
                <span class="metric-number"><?php echo e($totalParticipants); ?></span>
                <span class="metric-label">Total Peserta</span>
            </div>
        </div>
        <div class="metric-card success">
            <div class="metric-icon">✅</div>
            <div class="metric-content">
                <span class="metric-number"><?php echo e($paidParticipants); ?></span>
                <span class="metric-label">Lunas</span>
            </div>
        </div>
        <div class="metric-card warning">
            <div class="metric-icon">⏳</div>
            <div class="metric-content">
                <span class="metric-number"><?php echo e($unpaidParticipants); ?></span>
                <span class="metric-label">Belum Bayar</span>
            </div>
        </div>
        <div class="metric-card info">
            <div class="metric-icon">💰</div>
            <div class="metric-content">
                <span class="metric-number">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></span>
                <span class="metric-label">Total Pendapatan</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Management Actions -->
<div class="dashboard-section">
    <h2 class="section-title">⚡ Aksi Cepat</h2>
    <div class="quick-actions-grid">
        <a href="<?php echo e(route('tambah.user')); ?>" class="action-card">
            <span class="action-icon">👥</span>
            <span class="action-label">Tambah User</span>
        </a>
        <a href="<?php echo e(route('tambah.daerah')); ?>" class="action-card">
            <span class="action-icon">🌍</span>
            <span class="action-label">Tambah Daerah</span>
        </a>
        <a href="<?php echo e(route('tambah.kategori')); ?>" class="action-card">
            <span class="action-icon">🏷️</span>
            <span class="action-label">Kategori</span>
        </a>
    </div>
</div>

<!-- Analytics & Recent Activity -->
<div class="dashboard-section">
    <h2 class="section-title">📊 Analitik & Aktivitas</h2>
    <div class="analytics-grid">
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['title' => '📊 Statistik Pembayaran']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => '📊 Statistik Pembayaran']); ?>
            <div style="height: 120px;">
                <canvas id="paymentChart"></canvas>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['title' => '🆕 Peserta Terbaru']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => '🆕 Peserta Terbaru']); ?>
            <div class="latest-list">
                <?php $__empty_1 = true; $__currentLoopData = $latestParticipants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="latest-item">
                        <div class="latest-avatar">
                            <?php echo e(substr($p->name, 0, 1)); ?>

                        </div>
                        <div class="latest-info">
                            <div class="latest-name"><?php echo e($p->name); ?></div>
                            <div class="latest-meta"><?php echo e($p->region->name ?? '-'); ?> • <?php echo e($p->created_at->diffForHumans()); ?></div>
                        </div>
                        <a href="<?php echo e(route('detail.peserta', $p->id)); ?>" class="btn-icon-only" style="width: 32px; height: 32px; font-size: 0.8rem;">➡️</a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-4 text-muted">Belum ada peserta baru</div>
                <?php endif; ?>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
    </div>
</div>

<!-- Regional Data -->
<div class="dashboard-section">
    <?php if (isset($component)) { $__componentOriginal436399e29d00ce6b8f47e38277d39536 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal436399e29d00ce6b8f47e38277d39536 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-header','data' => ['title' => 'Data Peserta per Wilayah','icon' => '🌍']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Data Peserta per Wilayah','icon' => '🌍']); ?>
        <a href="<?php echo e(route('keseluruhan.peserta')); ?>" class="btn-icon-only">📋</a>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal436399e29d00ce6b8f47e38277d39536)): ?>
<?php $attributes = $__attributesOriginal436399e29d00ce6b8f47e38277d39536; ?>
<?php unset($__attributesOriginal436399e29d00ce6b8f47e38277d39536); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal436399e29d00ce6b8f47e38277d39536)): ?>
<?php $component = $__componentOriginal436399e29d00ce6b8f47e38277d39536; ?>
<?php unset($__componentOriginal436399e29d00ce6b8f47e38277d39536); ?>
<?php endif; ?>
    
    <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $participantsByRegion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="font-weight:700;"><?php echo e($region->name); ?></td>
                        <td style="color:var(--text-muted); font-size:0.8rem;"><?php echo e($region->participants_count); ?> Peserta</td>
                        <td>
                            <span class="badge badge-success"><?php echo e($region->paid_count ?? 0); ?> Lunas</span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php if (isset($component)) { $__componentOriginal4eed7548ad3bd4d0709494afb2239601 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4eed7548ad3bd4d0709494afb2239601 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-row','data' => ['colspan' => 3]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colspan' => 3]); ?>
                        Belum ada data region peserta
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4eed7548ad3bd4d0709494afb2239601)): ?>
<?php $attributes = $__attributesOriginal4eed7548ad3bd4d0709494afb2239601; ?>
<?php unset($__attributesOriginal4eed7548ad3bd4d0709494afb2239601); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4eed7548ad3bd4d0709494afb2239601)): ?>
<?php $component = $__componentOriginal4eed7548ad3bd4d0709494afb2239601; ?>
<?php unset($__componentOriginal4eed7548ad3bd4d0709494afb2239601); ?>
<?php endif; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
</div>

<!-- Secondary Actions -->
<div class="dashboard-section">
    <div class="secondary-actions">
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'success','style' => 'flex: 1;','onclick' => 'shareToWA()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','style' => 'flex: 1;','onclick' => 'shareToWA()']); ?>
            📤 Share ke WhatsApp
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'secondary','style' => 'flex: 1;','onclick' => 'showPdfDialog()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'secondary','style' => 'flex: 1;','onclick' => 'showPdfDialog()']); ?>
            📥 Export PDF
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
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


<div id="chartData" 
     data-paid="<?php echo e($paidParticipants); ?>"
     data-unpaid="<?php echo e($unpaidParticipants); ?>"
     data-category-labels="<?php echo e(json_encode($participantsByCategory->pluck('name')->toArray())); ?>"
     data-category-data="<?php echo e(json_encode($participantsByCategory->pluck('participants_count')->toArray())); ?>"
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
    window.location.href = "<?php echo e(route('pdf.admin.report')); ?>?sortBy=" + sortBy;
}

// WhatsApp Share Function
function shareToWA() {
    fetch("<?php echo e(route('admin.share.whatsapp')); ?>")
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\test\apk\mangkatan\resources\views/dashboard-admin.blade.php ENDPATH**/ ?>