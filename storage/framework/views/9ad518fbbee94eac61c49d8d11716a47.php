<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => null,
    'name' => null,
    'label' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'options' => [],
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
    'error' => null,
    'options' => [],
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

    <!-- Hidden input to store the selected value -->
    <input
        type="hidden"
        id="<?php echo e($id); ?>"
        name="<?php echo e($name); ?>"
        value="<?php echo e($value); ?>"
        <?php echo e($required ? 'required' : ''); ?>

    />

    <!-- Custom dropdown -->
    <div class="custom-dropdown <?php echo e($error ? 'is-invalid' : ''); ?> <?php echo e($disabled ? 'disabled' : ''); ?>" data-dropdown-id="<?php echo e($id); ?>">
        <div class="dropdown-trigger" tabindex="0">
            <span class="selected-text">
                <?php if($value && isset($options[$value])): ?>
                    <?php echo e($options[$value]); ?>

                <?php else: ?>
                    <?php echo e($placeholder ?: 'Pilih opsi...'); ?>

                <?php endif; ?>
            </span>
            <span class="dropdown-arrow">▼</span>
        </div>
        <div class="dropdown-options">
            <?php if(!empty($options)): ?>
                <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="dropdown-option <?php echo e($value == $key ? 'selected' : ''); ?>" data-value="<?php echo e($key); ?>">
                        <?php echo e($option); ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>

    <?php if($error): ?>
        <div class="invalid-feedback">
            <?php echo e($error); ?>

        </div>
    <?php endif; ?>
</div>

<style>
.custom-dropdown {
    position: relative;
    width: 100%;
}

.dropdown-trigger {
    width: 100%;
    padding: 1rem 1.35rem;
    border-radius: var(--radius-lg);
    border: 2px solid transparent;
    background: linear-gradient(var(--bg-secondary), var(--bg-secondary)) padding-box,
                linear-gradient(135deg, var(--primary), var(--primary-dark)) border-box;
    color: var(--text-main);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: var(--transition-base);
    outline: none;
    min-height: 48px;
    font-size: 1rem;
    font-family: var(--font-body);
    font-weight: 500;
}

.dropdown-trigger:focus {
    border: 2px solid transparent;
    background: linear-gradient(var(--bg-secondary), var(--bg-secondary)) padding-box,
                linear-gradient(135deg, var(--primary), var(--primary-dark)) border-box;
    box-shadow: 0 0 0 4px var(--primary-light), var(--shadow-sm);
    transform: translateY(-1px);
}

.dropdown-trigger:hover:not(.disabled) {
    border: 2px solid transparent;
    background: linear-gradient(var(--bg-accent), var(--bg-accent)) padding-box,
                linear-gradient(135deg, var(--primary-light), var(--primary)) border-box;
    transform: translateY(-0.5px);
}

.custom-dropdown.open .dropdown-trigger {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom: 2px solid var(--primary);
}

.dropdown-arrow {
    transition: transform 0.3s ease;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.custom-dropdown.open .dropdown-arrow {
    transform: rotate(180deg);
}

.dropdown-options {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--bg-secondary);
    border: 2px solid var(--primary);
    border-top: none;
    border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    box-shadow: var(--shadow-lg);
}

.custom-dropdown.open .dropdown-options {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-option {
    padding: 0.75rem 1.35rem;
    cursor: pointer;
    transition: background 0.2s ease;
    border-bottom: 1px solid var(--border-light);
    outline: none;
}

.dropdown-option:last-child {
    border-bottom: none;
}

.dropdown-option:hover,
.dropdown-option:focus {
    background: var(--primary-light);
    color: var(--primary);
}

.dropdown-option.selected {
    background: var(--primary);
    color: white;
}

.custom-dropdown.disabled {
    opacity: 0.6;
    pointer-events: none;
}

.custom-dropdown.is-invalid .dropdown-trigger {
    border: 2px solid transparent !important;
    background: linear-gradient(var(--bg-secondary), var(--bg-secondary)) padding-box,
                linear-gradient(135deg, var(--danger), var(--danger-dark)) border-box !important;
}

.custom-dropdown.is-invalid .dropdown-trigger:focus {
    box-shadow: 0 0 0 4px var(--danger-light) !important;
}
</style>
<?php /**PATH C:\test\apk\mangkatan\resources\views/components/select.blade.php ENDPATH**/ ?>