@props([
    'id' => null,
    'name' => null,
    'label' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'options' => [],
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
    
    <select 
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        class="form-control {{ $error ? 'is-invalid' : '' }}"
        {{ $attributes }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        {{ $slot }}
    </select>
    
    @if($error)
        <div class="invalid-feedback">
            {{ $error }}
        </div>
    @endif
</div>