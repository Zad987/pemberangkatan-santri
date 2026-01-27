@props([
    'label' => '',
    'options' => [],
    'required' => false,
    'helper' => '',
    'error' => null,
    'placeholder' => 'Pilih...'
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
        <select 
            class="form-input {{ $error ? 'is-invalid' : '' }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes }}>
            <option value="">{{ $placeholder }}</option>
            @foreach($options as $value => $text)
                <option value="{{ $value }}">{{ $text }}</option>
            @endforeach
        </select>
    </div>
    
    @if($error)
        <small class="text-danger mt-1 d-block">{{ $error }}</small>
    @elseif($helper)
        <small class="text-muted mt-1 d-block">{{ $helper }}</small>
    @endif
</div>
