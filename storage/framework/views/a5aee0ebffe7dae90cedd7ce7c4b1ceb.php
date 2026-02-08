<?php $__env->startSection('title', 'Akses Ditolak'); ?>

<?php $__env->startSection('content'); ?>
<div class="error-container fade-in">
    <div class="error-icon">🔒</div>
    <h1 class="error-title">Akses Terbatas</h1>
    <p class="error-message">Maaf, akun Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi admin jika ini adalah kesalahan.</p>

    <div class="flex-actions w-full" style="justify-content: center;">
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(url()->previous()); ?>" class="btn-primary" style="background: var(--text-muted);">Kembali</a>
            <a href="<?php echo e(route('dashboard.' . (Auth::user()->role->value == 'induk' ? 'admin' : (Auth::user()->role->value == 'daerah' ? 'daerah' : 'pengunjung')))); ?>" class="btn-primary">Dashboard</a>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="btn-primary">Halaman Login</a>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\test\apk\mangkatan\resources\views/errors/403.blade.php ENDPATH**/ ?>