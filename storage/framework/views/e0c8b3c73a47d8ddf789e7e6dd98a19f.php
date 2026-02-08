<?php $__env->startSection('title', 'Detail Peserta - ' . $participant->name); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal436399e29d00ce6b8f47e38277d39536 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal436399e29d00ce6b8f47e38277d39536 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-header','data' => ['title' => '👤 Detail Peserta','icon' => '👤']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => '👤 Detail Peserta','icon' => '👤']); ?>
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
    <div class="detail-header">
        <h2 style="margin: 0 0 0.5rem 0; font-size: 1.5rem; font-weight: 700; color: var(--text-main);">
            <?php echo e($participant->name); ?>

        </h2>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; font-size: 0.9rem; color: var(--text-muted);">
            <span style="display: flex; align-items: center; gap: 0.5rem;">
                📍 <?php echo e($participant->region->name ?? 'Wilayah tidak ditemukan'); ?>

            </span>
            <span style="display: flex; align-items: center; gap: 0.5rem;">
                🏷️ <?php echo e($participant->category->name ?? 'Kategori tidak ditemukan'); ?>

            </span>
        </div>
    </div>

    <div class="mb-4">
        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 700; color: var(--text-muted);">
            <span>Progress Pembayaran</span>
            <span id="payment-progress-percent"><?php echo e(round($paymentProgress)); ?>%</span>
        </div>
        <div style="height: 12px; background: var(--bg-accent); border-radius: 10px; overflow: hidden; border: 1px solid var(--border-light);">
            <div id="payment-progress-bar" style="height: 100%; background: var(--gradient-success); transition: width 0.5s ease;"></div>
        </div>
    </div>

    <div class="detail-info-grid">
        <div class="info-item">
            <span class="info-label">Biaya Pendaftaran</span>
            <div class="info-value">Rp <?php echo e(number_format($categoryPrice, 0, ',', '.')); ?></div>
        </div>
        <div class="grid-2">
            <div class="info-item">
                <span class="info-label">Total Bayar</span>
                <div class="info-value text-success">Rp <?php echo e(number_format($totalPaid, 0, ',', '.')); ?></div>
            </div>
            <div class="info-item">
                <span class="info-label">Sisa Pembayaran</span>
                <div class="info-value <?php echo e($isFullyPaid ? 'text-success' : 'text-danger'); ?>">
                    <?php if($isFullyPaid): ?>
                        ✓ Lunas
                    <?php else: ?>
                        Rp <?php echo e(number_format($remainingBalance, 0, ',', '.')); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if(!$isFullyPaid): ?>
        <div style="background: rgba(217, 119, 6, 0.05); border-left: 4px solid var(--warning); padding: 1rem; border-radius: 8px; margin-top: 1rem;">
            <span style="color: var(--warning); font-weight: 700;">⚠️ Pembayaran Belum Lengkap</span>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Peserta masih memiliki sisa pembayaran yang harus diselesaikan.</p>
        </div>
    <?php else: ?>
        <div style="background: rgba(5, 150, 105, 0.05); border-left: 4px solid var(--success); padding: 1rem; border-radius: 8px; margin-top: 1rem;">
            <span style="color: var(--success); font-weight: 700;">✓ Pembayaran Lengkap</span>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Peserta telah menyelesaikan semua pembayaran.</p>
        </div>
    <?php endif; ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['title' => '📝 Update Pembayaran']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => '📝 Update Pembayaran']); ?>
    <form method="POST" action="<?php echo e(route('update.payment', $participant->id)); ?>" id="paymentForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <?php if($errors->has('amount')): ?>
            <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid var(--danger); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <span style="color: var(--danger); font-weight: 700;">❌ Kesalahan Pembayaran</span>
                <p style="color: var(--text-main); font-size: 0.9rem; margin-top: 0.5rem;"><?php echo e($errors->first('amount')); ?></p>
            </div>
        <?php endif; ?>

        <?php if($isFullyPaid): ?>
            <div style="background: rgba(5, 150, 105, 0.1); border-left: 4px solid var(--success); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <span style="color: var(--success); font-weight: 700;">✓ Peserta Sudah Lunas</span>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Peserta telah menyelesaikan semua pembayaran dan tidak dapat menambah pembayaran baru.</p>
            </div>
            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['buttonType' => 'button','block' => true,'style' => 'background: var(--border); color: var(--text-muted);','disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['buttonType' => 'button','block' => true,'style' => 'background: var(--border); color: var(--text-muted);','disabled' => true]); ?>
                💾 Peserta Sudah Lunas (Tidak Bisa Diubah)
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
        <?php else: ?>
            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['id' => 'amount','name' => 'amount','type' => 'number','label' => 'Jumlah Bayar Baru (Rp)','placeholder' => '0','step' => '1000','min' => '0','required' => true,'value' => old('amount'),'oninput' => 'calculateRemaining(this.value)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'amount','name' => 'amount','type' => 'number','label' => 'Jumlah Bayar Baru (Rp)','placeholder' => '0','step' => '1000','min' => '0','required' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('amount')),'oninput' => 'calculateRemaining(this.value)']); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <div id="remaining-feedback" style="display: none; background: var(--primary-light); padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px dashed var(--primary);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--primary-dark);">Sisa Setelah Bayar:</span>
                    <span id="new-remaining" style="font-size: 1.1rem; font-weight: 900; color: var(--primary);">Rp 0</span>
                </div>
            </div>

            <div style="background: rgba(59, 130, 246, 0.05); border-left: 4px solid var(--primary); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                    <strong>Limit Pembayaran:</strong> Rp <?php echo e(number_format($remainingBalance, 0, ',', '.')); ?>

                </div>
            </div>

            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['id' => 'payment_date','name' => 'payment_date','type' => 'date','label' => 'Tanggal Pembayaran','required' => true,'value' => old('payment_date', date('Y-m-d'))]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'payment_date','name' => 'payment_date','type' => 'date','label' => 'Tanggal Pembayaran','required' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('payment_date', date('Y-m-d')))]); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.textarea','data' => ['id' => 'notes','name' => 'notes','label' => 'Catatan (Opsional)','placeholder' => 'Tambahkan catatan pembayaran (contoh: Transfer BRI, Via Cash, dll)','rows' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'notes','name' => 'notes','label' => 'Catatan (Opsional)','placeholder' => 'Tambahkan catatan pembayaran (contoh: Transfer BRI, Via Cash, dll)','rows' => '2']); ?><?php echo e(old('notes')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $attributes = $__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__attributesOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886)): ?>
<?php $component = $__componentOriginal4727f9fd7c3055c2cf9c658d89b16886; ?>
<?php unset($__componentOriginal4727f9fd7c3055c2cf9c658d89b16886); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['buttonType' => 'submit','block' => true,'id' => 'submitPaymentBtn']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['buttonType' => 'submit','block' => true,'id' => 'submitPaymentBtn']); ?>
                💰 Proses Pembayaran
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
        <?php endif; ?>
    </form>
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

<?php if (isset($component)) { $__componentOriginal436399e29d00ce6b8f47e38277d39536 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal436399e29d00ce6b8f47e38277d39536 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-header','data' => ['title' => 'Riwayat Pembayaran','icon' => '&#128221;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Riwayat Pembayaran','icon' => '&#128221;']); ?>
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
    <?php $__empty_1 = true; $__currentLoopData = $participant->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="payment-item">
        <div class="payment-meta">
            <div class="payment-date"><?php echo e(\Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d M Y')); ?></div>
            <div class="payment-amount">Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?></div>
        </div>
        <div class="payment-body">
            <span class="badge <?php echo e($payment->status == 'lunas' ? 'badge-success' : 'badge-warning'); ?>">
                <?php echo e($payment->status == 'lunas' ? '✓ Lunas' : '⏳ Menunggu'); ?>

            </span>
            <span class="payment-notes"><?php echo e($payment->notes ?: 'Tidak ada catatan'); ?></span>
        </div>
        <div class="payment-actions">
            <form method="POST" action="<?php echo e(route('payment.destroy', $payment->id)); ?>" onsubmit="return confirmDelete(event, this)">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['buttonType' => 'submit','class' => 'delete-payment-btn','style' => 'background: var(--danger); padding: 0.35rem 0.75rem; font-size: 0.85rem;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['buttonType' => 'submit','class' => 'delete-payment-btn','style' => 'background: var(--danger); padding: 0.35rem 0.75rem; font-size: 0.85rem;']); ?>
                    🗑️ Hapus
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
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-payments">Belum ada riwayat pembayaran</div>
    <?php endif; ?>
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

<div class="mt-4 fade-in flex-actions">
    <a href="<?php echo e(route('peserta.edit', $participant->id)); ?>" class="btn-primary" style="flex: 1; background: var(--warning);">
        ✏️ Edit Profil
    </a>
    <form method="POST" action="<?php echo e(route('peserta.destroy', $participant->id)); ?>" style="flex: 1;" onsubmit="return confirmDeleteParticipant(event, this)">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['buttonType' => 'submit','style' => 'width: 100%; background: var(--danger);']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['buttonType' => 'submit','style' => 'width: 100%; background: var(--danger);']); ?>
            🗑️ Hapus Peserta
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
    </form>
</div>


<div id="detailData" 
     data-payment-progress="<?php echo e($paymentProgress); ?>"
     data-remaining-balance="<?php echo e($remainingBalance); ?>"
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\test\apk\mangkatan\resources\views/detail-peserta.blade.php ENDPATH**/ ?>