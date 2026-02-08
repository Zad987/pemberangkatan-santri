<?php $__env->startSection('title', 'Data Peserta'); ?>

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

<?php if (isset($component)) { $__componentOriginal436399e29d00ce6b8f47e38277d39536 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal436399e29d00ce6b8f47e38277d39536 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-header','data' => ['title' => 'Data Peserta Keseluruhan','icon' => '&#128202;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Data Peserta Keseluruhan','icon' => '&#128202;']); ?>
    <div class="flex-actions" style="gap: 1rem; align-items: center;">
        <div style="position: relative; width: 100%; max-width: 350px;">
            <input type="text" id="searchInput" class="form-input" placeholder="Cari nama peserta..." style="padding-left: 2.8rem; height: 48px; font-size: 0.95rem; border-radius: 24px;">
            <span style="position: absolute; left: 1.2rem; top: 50%; transform: translateY(-50%); opacity: 0.6; font-size: 1.1rem;">&#128269;</span>
        </div>
        <div class="stats-summary" style="display: flex; gap: 1rem; font-size: 0.9rem; color: var(--text-muted);">
            <span>Total: <strong id="totalCount"><?php echo e($participants->count()); ?></strong></span>
            <span>Lunas: <strong id="paidCount" style="color: var(--success);"><?php echo e($participants->filter(fn($p) => $p->is_paid)->count()); ?></strong></span>
            <span>Belum: <strong id="unpaidCount" style="color: var(--danger);"><?php echo e($participants->filter(fn($p) => !$p->is_paid)->count()); ?></strong></span>
        </div>
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

<!-- Statistics Cards -->
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="metric-card primary">
        <div class="metric-icon">&#128101;</div>
        <div class="metric-content">
            <div class="metric-number"><?php echo e($participants->count()); ?></div>
            <div class="metric-label">Total Peserta</div>
        </div>
    </div>

    <div class="metric-card success">
        <div class="metric-icon">&#9989;</div>
        <div class="metric-content">
            <div class="metric-number"><?php echo e($participants->filter(fn($p) => $p->is_paid)->count()); ?></div>
            <div class="metric-label">Sudah Lunas</div>
        </div>
    </div>

    <div class="metric-card warning">
        <div class="metric-icon">&#8987;</div>
        <div class="metric-content">
            <div class="metric-number"><?php echo e($participants->filter(fn($p) => !$p->is_paid)->count()); ?></div>
            <div class="metric-label">Belum Lunas</div>
        </div>
    </div>

    <div class="metric-card info">
        <div class="metric-icon">&#128205;</div>
        <div class="metric-content">
            <div class="metric-number"><?php echo e($participants->pluck('region.name')->unique()->count()); ?></div>
            <div class="metric-label">Wilayah</div>
        </div>
    </div>
</div>

<?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['class' => 'fade-in']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'fade-in']); ?>
    <div class="table-responsive">
        <table id="participantTable" class="participant-table">
            <thead>
                <tr>
                    <th style="width: 60%;">&#128100; Peserta</th>
                    <th style="width: 20%;">&#127991; Kategori</th>
                    <th style="width: 20%; text-align: center;">&#128176; Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="participant-row <?php echo e($participant->is_paid ? 'paid' : 'unpaid'); ?>">
                    <td>
                        <div class="participant-info">
                            <div class="participant-name"><?php echo e($participant->name); ?></div>
                            <div class="participant-region">
                                <span class="region-icon">&#128205;</span>
                                <?php echo e($participant->region?->name ?? 'Tidak ada wilayah'); ?>

                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="category-badge">
                            <span class="category-icon">&#127991;</span>
                            <?php echo e($participant->category?->name ?? 'Tidak ada kategori'); ?>

                        </span>
                    </td>
                    <td style="text-align: center;">
                        <?php if($participant->latestPayment && $participant->latestPayment->status == 'lunas'): ?>
                            <span class="status-badge status-paid">
                                <span class="status-icon">&#9989;</span>
                                Lunas
                            </span>
                        <?php else: ?>
                            <span class="status-badge status-unpaid">
                                <span class="status-icon">&#8987;</span>
                                Belum Lunas
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" class="empty-state">
                        <div class="empty-state-icon">&#128235;</div>
                        <div class="empty-state-text">Tidak ada data peserta</div>
                    </td>
                </tr>
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

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.metric-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    border-radius: var(--radius-md);
    background: var(--gradient-card);
    border: 1px solid var(--glass-border);
    box-shadow: var(--shadow-sm);
    transition: var(--transition-base);
}

.metric-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.metric-card.primary { border-left: 4px solid var(--primary); }
.metric-card.success { border-left: 4px solid var(--success); }
.metric-card.warning { border-left: 4px solid var(--warning); }
.metric-card.info { border-left: 4px solid var(--info); }

.metric-icon {
    font-size: 2rem;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-full);
    background: var(--primary-light);
    color: var(--primary);
}

.metric-content {
    flex: 1;
}

.metric-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 0.25rem;
}

.metric-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stats-summary {
    background: var(--bg-accent);
    padding: 0.75rem 1.25rem;
    border-radius: 20px;
    border: 1px solid var(--border-light);
    font-weight: 600;
}

.participant-table {
    border-collapse: separate;
    border-spacing: 0 8px;
    margin: -8px 0;
}

.participant-table thead th {
    background: var(--bg-accent);
    color: var(--text-main);
    padding: 1.25rem 1.5rem;
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    border-bottom: 2px solid var(--border-light);
}

.participant-row {
    background: var(--card);
    border-radius: 12px;
    border: 1px solid var(--border-light);
    margin-bottom: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.participant-row:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    border-color: var(--primary-light);
}

.participant-row.paid {
    border-left: 4px solid var(--success);
}

.participant-row.unpaid {
    border-left: 4px solid var(--danger);
}

.participant-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.participant-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-main);
    line-height: 1.3;
}

.participant-region {
    font-size: 0.85rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 4px;
}

.region-icon {
    font-size: 0.8rem;
    opacity: 0.7;
}

.category-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--bg-accent);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-secondary);
    border: 1px solid var(--border-light);
}

.category-icon {
    font-size: 0.9rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 24px;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.status-paid {
    background: linear-gradient(135deg, var(--success-light) 0%, var(--success) 100%);
    color: white;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.status-unpaid {
    background: linear-gradient(135deg, var(--danger-light) 0%, var(--danger) 100%);
    color: white;
    border: 1px solid rgba(220, 38, 38, 0.2);
}

.status-icon {
    font-size: 1rem;
}

.participant-table tbody td {
    padding: 1.5rem;
    border: none;
    vertical-align: middle;
}

.participant-table tbody td:first-child {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}

.participant-table tbody td:last-child {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
}

.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    background: var(--bg-accent);
    border-radius: 16px;
    border: 2px dashed var(--border-light);
}

.empty-state-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state-text {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-muted);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .metric-card {
        padding: 1rem;
    }

    .metric-number {
        font-size: 1.5rem;
    }

    .participant-table thead th {
        padding: 1rem;
        font-size: 0.8rem;
    }

    .participant-table tbody td {
        padding: 1rem;
    }

    .participant-name {
        font-size: 1rem;
    }

    .status-badge {
        padding: 6px 12px;
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .flex-actions {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .stats-summary {
        text-align: center;
        padding: 1rem;
    }

    .participant-table {
        font-size: 0.9rem;
    }

    .participant-info {
        gap: 2px;
    }

    .participant-name {
        font-size: 0.95rem;
    }
}
</style>

<?php echo $__env->make('components.extra-responsive', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#participantTable tbody tr');
    let visibleCount = 0;
    let paidCount = 0;
    let unpaidCount = 0;

    rows.forEach(row => {
        if (row.classList.contains('participant-row')) {
            let name = row.querySelector('.participant-name').textContent.toLowerCase();
            let region = row.querySelector('.participant-region').textContent.toLowerCase();
            let category = row.querySelector('.category-badge').textContent.toLowerCase();

            if (name.includes(filter) || region.includes(filter) || category.includes(filter)) {
                row.style.display = "";
                visibleCount++;

                if (row.classList.contains('paid')) {
                    paidCount++;
                } else if (row.classList.contains('unpaid')) {
                    unpaidCount++;
                }
            } else {
                row.style.display = "none";
            }
        }
    });

    // Update summary counts
    document.getElementById('totalCount').textContent = visibleCount;
    document.getElementById('paidCount').textContent = paidCount;
    document.getElementById('unpaidCount').textContent = unpaidCount;
});

// Initialize counts on page load
document.addEventListener('DOMContentLoaded', function() {
    let rows = document.querySelectorAll('#participantTable tbody .participant-row');
    let paidCount = 0;
    let unpaidCount = 0;

    rows.forEach(row => {
        if (row.classList.contains('paid')) {
            paidCount++;
        } else if (row.classList.contains('unpaid')) {
            unpaidCount++;
        }
    });

    document.getElementById('totalCount').textContent = rows.length;
    document.getElementById('paidCount').textContent = paidCount;
    document.getElementById('unpaidCount').textContent = unpaidCount;
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\test\apk\mangkatan\resources\views/keseluruhan-peserta.blade.php ENDPATH**/ ?>