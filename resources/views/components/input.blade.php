@props([
    'label' => '',
    'type' => 'text',
    'required' => false,
    'helper' => '',
    'error' => null,
    'placeholder' => ''
])

<div class="form-group {{ $error ? 'has-error' : '' }}">
    @if($label)
        <label class="form-label" for="{{ $attributes->get('id') ?? '' }}">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    
    <div class="input-wrapper">
        <input 
            type="{{ $type }}"
            class="form-input {{ $error ? 'is-invalid' : '' }}"
            {{ $required ? 'required' : '' }}
            placeholder="{{ $placeholder }}"
            {{ $attributes }}>
    </div>
    
    @if($error)
        <small class="text-danger mt-1 d-block">{{ $error }}</small>
    @elseif($helper)
        <small class="text-muted mt-1 d-block">{{ $helper }}</small>
    @endif
</div>
