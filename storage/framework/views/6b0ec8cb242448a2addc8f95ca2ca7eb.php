<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'icon' => null,
    'class' => null
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => null,
    'icon' => null,
    'class' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="data-card fade-in <?php echo e($class); ?>">
    <?php if($title || $icon): ?>
        <div class="section-header px-4 pt-4 mb-0">
            <h3 class="heading-4 m-0">
                <?php if($icon): ?> <span class="me-2"><?php echo e($icon); ?></span> <?php endif; ?>
                <?php echo e($title); ?>

            </h3>
        </div>
    <?php endif; ?>
    
    <div class="p-4">
        <?php echo e($slot); ?>

    </div>
</div><?php /**PATH C:\test\apk\mangkatan\resources\views/components/card.blade.php ENDPATH**/ ?>