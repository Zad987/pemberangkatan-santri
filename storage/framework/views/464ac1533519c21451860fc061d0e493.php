<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => null,
    'name' => null,
    'type' => 'text',
    'label' => null,
    'placeholder' => null,
    'value' => null,
    'required' => false,
    'autofocus' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => null,
    'help' => null,
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left'
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
    'type' => 'text',
    'label' => null,
    'placeholder' => null,
    'value' => null,
    'required' => false,
    'autofocus' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => null,
    'help' => null,
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left'
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

    <div class="input-wrapper <?php echo e($icon ? 'has-icon' : ''); ?>">
        <?php if($icon && $iconPosition === 'left'): ?>
            <span class="input-icon left">
                <i class="<?php echo e($icon); ?>"></i>
            </span>
        <?php endif; ?>

        <input
            id="<?php echo e($id); ?>"
            name="<?php echo e($name); ?>"
            type="<?php echo e($type); ?>"
            value="<?php echo e(old($name, $value)); ?>"
            placeholder="<?php echo e($placeholder); ?>"
            <?php echo e($required ? 'required' : ''); ?>

            <?php echo e($autofocus ? 'autofocus' : ''); ?>

            <?php echo e($disabled ? 'disabled' : ''); ?>

            <?php echo e($readonly ? 'readonly' : ''); ?>

            class="form-control <?php echo e($error ? 'is-invalid' : ''); ?> <?php echo e($size === 'lg' ? 'form-control-lg' : ($size === 'sm' ? 'form-control-sm' : '')); ?>"
            <?php echo e($attributes); ?>

        >

        <?php if($icon && $iconPosition === 'right'): ?>
            <span class="input-icon right">
                <i class="<?php echo e($icon); ?>"></i>
            </span>
        <?php endif; ?>
    </div>

    <?php if($error): ?>
        <div class="invalid-feedback">
            <?php echo e($error); ?>

        </div>
    <?php endif; ?>

    <?php if($help): ?>
        <small class="form-text text-muted">
            <?php echo e($help); ?>

        </small>
    <?php endif; ?>
</div>
<?php /**PATH C:\test\apk\mangkatan\resources\views/components/input.blade.php ENDPATH**/ ?>