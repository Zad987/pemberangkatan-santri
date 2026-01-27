@props([
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
    
    <textarea 
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        class="form-control {{ $error ? 'is-invalid' : '' }}"
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>
    
    @if($error)
        <div class="invalid-feedback">
            {{ $error }}
        </div>
    @endif
</div>