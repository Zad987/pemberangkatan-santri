@props([
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
])

<div class="form-group">
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <div class="input-wrapper {{ $icon ? 'has-icon' : '' }}">
        @if($icon && $iconPosition === 'left')
            <span class="input-icon left">
                <i class="{{ $icon }}"></i>
            </span>
        @endif

        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $autofocus ? 'autofocus' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            class="form-control {{ $error ? 'is-invalid' : '' }} {{ $size === 'lg' ? 'form-control-lg' : ($size === 'sm' ? 'form-control-sm' : '') }}"
            {{ $attributes }}
        >

        @if($icon && $iconPosition === 'right')
            <span class="input-icon right">
                <i class="{{ $icon }}"></i>
            </span>
        @endif
    </div>

    @if($error)
        <div class="invalid-feedback">
            {{ $error }}
        </div>
    @endif

    @if($help)
        <small class="form-text text-muted">
            {{ $help }}
        </small>
    @endif
</div>
