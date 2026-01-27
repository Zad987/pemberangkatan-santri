<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'button',
    'size' => 'md',
    'disabled' => false,
    'loading' => false,
    'block' => false,
    'buttonType' => 'button'
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
    'type' => 'button',
    'size' => 'md',
    'disabled' => false,
    'loading' => false,
    'block' => false,
    'buttonType' => 'button'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $sizeClass = match($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => ''
    };
    $blockClass = $block ? 'w-full' : '';
    $typeClass = match($type) {
        'danger' => 'btn-danger',
        'warning' => 'btn-warning',
        'success' => 'btn-success',
        'secondary' => 'btn-secondary',
        'outline' => 'btn-outline',
        default => 'btn-primary'
    };
?>

<button 
    type="<?php echo e($buttonType); ?>" 
    class="<?php echo e($typeClass); ?> <?php echo e($sizeClass); ?> <?php echo e($blockClass); ?> <?php echo e($loading ? 'btn-loading' : ''); ?>"
    <?php echo e($disabled || $loading ? 'disabled' : ''); ?>

    <?php echo e($attributes); ?>>
    <?php if($loading): ?>
        <span class="spinner-border"></span>
    <?php endif; ?>
    <?php echo e($slot); ?>

</button>
<?php /**PATH C:\test\apk\mangkatan\resources\views/components/button.blade.php ENDPATH**/ ?>