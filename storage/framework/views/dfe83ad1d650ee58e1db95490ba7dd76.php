<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => null,
    'name' => null,
    'label' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => null,
    'rows' => 4,
    'value' => null
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
    'id' => null,
    'name' => null,
    'label' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => null,
    'rows' => 4,
    'value' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="form-group">
    <?php if($label): ?>
        <label for="<?php echo e($id); ?>" class="form-label">
            <?php echo e($label); ?>

            <?php if($required): ?>
                <span class="text-danger">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>
    
    <textarea 
        id="<?php echo e($id); ?>"
        name="<?php echo e($name); ?>"
        rows="<?php echo e($rows); ?>"
        placeholder="<?php echo e($placeholder); ?>"
        <?php echo e($required ? 'required' : ''); ?>

        <?php echo e($disabled ? 'disabled' : ''); ?>

        <?php echo e($readonly ? 'readonly' : ''); ?>

        class="form-control <?php echo e($error ? 'is-invalid' : ''); ?>"
        <?php echo e($attributes); ?>

    ><?php echo e(old($name, $value)); ?></textarea>
    
    <?php if($error): ?>
        <div class="invalid-feedback">
            <?php echo e($error); ?>

        </div>
    <?php endif; ?>
</div><?php /**PATH C:\test\apk\mangkatan\resources\views/components/textarea.blade.php ENDPATH**/ ?>