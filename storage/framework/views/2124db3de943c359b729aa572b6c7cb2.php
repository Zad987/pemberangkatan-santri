<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="breadcrumb-item <?php echo e($loop->last ? 'active' : ''); ?>">
                <?php if($breadcrumb['url'] && !$loop->last): ?>
                    <a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e($breadcrumb['icon'] ?? ''); ?> <?php echo e($breadcrumb['title']); ?></a>
                <?php else: ?>
                    <span><?php echo e($breadcrumb['icon'] ?? ''); ?> <?php echo e($breadcrumb['title']); ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav><?php /**PATH C:\test\apk\mangkatan\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>