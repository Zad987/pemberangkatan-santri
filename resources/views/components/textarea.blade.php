@props([
    'label' => '',
    'required' => false,
    'helper' => '',
    'error' => null,
    'placeholder' => '',
    'rows' => 4
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
        <textarea 
            class="form-input {{ $error ? 'is-invalid' : '' }}"
            rows="{{ $rows }}"
            {{ $required ? 'required' : '' }}
            placeholder="{{ $placeholder }}"
            {{ $attributes }}>{{ $slot }}</textarea>
    </div>
    
    @if($error)
        <small class="text-danger mt-1 d-block">{{ $error }}</small>
    @elseif($helper)
        <small class="text-muted mt-1 d-block">{{ $helper }}</small>
    @endif
</div>
