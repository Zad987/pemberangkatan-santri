<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => '',
    'type' => 'text',
    'required' => false,
    'helper' => '',
    'error' => null,
    'placeholder' => ''
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
    'label' => '',
    'type' => 'text',
    'required' => false,
    'helper' => '',
    'error' => null,
    'placeholder' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="form-group <?php echo e($error ? 'has-error' : ''); ?>">
    <?php if($label): ?>
        <label class="form-label" for="<?php echo e($attributes->get('id') ?? ''); ?>">
            <?php echo e($label); ?>

            <?php if($required): ?>
                <span class="text-danger">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>
    
    <div class="input-wrapper">
        <input 
            type="<?php echo e($type); ?>"
            class="form-input <?php echo e($error ? 'is-invalid' : ''); ?>"
            <?php echo e($required ? 'required' : ''); ?>

            placeholder="<?php echo e($placeholder); ?>"
            <?php echo e($attributes); ?>>
    </div>
    
    <?php if($error): ?>
        <small class="text-danger mt-1 d-block"><?php echo e($error); ?></small>
    <?php elseif($helper): ?>
        <small class="text-muted mt-1 d-block"><?php echo e($helper); ?></small>
    <?php endif; ?>
</div>
<?php /**PATH C:\test\apk\mangkatan\resources\views/components/input.blade.php ENDPATH**/ ?>