<?php $__env->startSection('title', 'Detail User'); ?>

<?php $__env->startSection('content'); ?>
<div class="section-header fade-in">
    <h2>Manajemen User</h2>
</div>

<div class="section-card fade-in">
    <h3 class="section-title-alt">&#128100; Profil Pengguna</h3>
    <?php
        $roleValue = $user->role instanceof \App\Enums\UserRole ? $user->role->value : $user->role;
    ?>
    <form method="POST" action="<?php echo e(route('user.update', $user->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-input <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('name', $user->name)); ?>" required>
            <?php if($errors->has('name')): ?>
                <small class="text-danger"><?php echo e($errors->first('name')); ?></small>
            <?php endif; ?>
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label for="role">Tipe Akun</label>
                <select id="role" name="role" class="form-input <?php echo e($errors->has('role') ? 'is-invalid' : ''); ?>" required onchange="toggleRegionField()">
                    <option value="induk" <?php echo e(old('role', $roleValue) == 'induk' ? 'selected' : ''); ?>>Admin</option>
                    <option value="daerah" <?php echo e(old('role', $roleValue) == 'daerah' ? 'selected' : ''); ?>>Daerah</option>
                    <option value="umum" <?php echo e(old('role', $roleValue) == 'umum' ? 'selected' : ''); ?>>Umum</option>
                </select>
                <?php if($errors->has('role')): ?>
                    <small class="text-danger"><?php echo e($errors->first('role')); ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="region_id">Wilayah Tugas</label>
                <select id="region_id" name="region_id" class="form-input <?php echo e($errors->has('region_id') ? 'is-invalid' : ''); ?>">
                    <option value="">Tidak Ada</option>
                    <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($region->id); ?>" <?php echo e(old('region_id', $user->region_id) == $region->id ? 'selected' : ''); ?>><?php echo e($region->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php if($errors->has('region_id')): ?>
                    <small class="text-danger"><?php echo e($errors->first('region_id')); ?></small>
                <?php endif; ?>
            </div>
        </div>
        <button type="submit" class="btn-primary w-full">Simpan Perubahan</button>
    </form>
</div>

<div class="section-card fade-in">
    <h3 class="section-title-alt">&#128273; Keamanan</h3>
        <form method="POST" action="<?php echo e(route('user.password.update', $user->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password" class="form-input <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>" placeholder="Min. 8 karakter" required>
            <?php if($errors->has('password')): ?>
                <small class="text-danger"><?php echo e($errors->first('password')); ?></small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input <?php echo e($errors->has('password_confirmation') ? 'is-invalid' : ''); ?>" required>
            <?php if($errors->has('password_confirmation')): ?>
                <small class="text-danger"><?php echo e($errors->first('password_confirmation')); ?></small>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn-primary w-full" style="background: var(--text-main);">Ganti Password</button>
    </form>
</div>

<div class="section-card fade-in">
    <h3 class="section-title-alt">&#9881;&#65039; Opsi Lanjutan</h3>
    <div class="flex-actions">
        <form method="POST" action="<?php echo e(route('user.logout.device', $user->id)); ?>" style="flex: 1;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-primary w-full" style="background: var(--warning);">Reset Perangkat</button>
        </form>
        <form method="POST" action="<?php echo e(route('user.destroy', $user->id)); ?>" style="flex: 1;" onsubmit="return confirm('Hapus user ini selamanya?');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\test\apk\mangkatan\resources\views/detail-user.blade.php ENDPATH**/ ?>