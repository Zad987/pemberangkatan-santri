<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'buttonType' => 'button',
    'size' => 'md',
    'variant' => 'primary',
    'block' => false,
    'disabled' => false,
    'loading' => false,
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
    'buttonType' => 'button',
    'size' => 'md',
    'variant' => 'primary',
    'block' => false,
    'disabled' => false,
    'loading' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<button 
    type="<?php echo e($buttonType); ?>"
    <?php echo e($disabled || $loading ? 'disabled' : ''); ?>

    <?php echo e($attributes->merge(['class' => "btn-$variant btn-$size" . ($block ? ' w-full' : '') . ($loading ? ' btn-loading' : '') . ' btn'])); ?>

>
    <?php if($loading): ?>
        <span class="spinner-border"></span>
    <?php endif; ?>
    <?php echo e($slot); ?>

</button><?php /**PATH C:\test\apk\mangkatan\resources\views/components/button.blade.php ENDPATH**/ ?>