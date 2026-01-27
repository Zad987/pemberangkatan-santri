@props([
    'type' => 'button',
    'size' => 'md',
    'disabled' => false,
    'loading' => false,
    'block' => false,
    'buttonType' => 'button'
])

@php
    $sizeClass = match($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => ''
    };
    $blockClass = $block ? 'w-full' : '';
    $typeClass = match($type) {
        'danger' => 'btn-danger',
        'warning' => 'btn-warning',
        'success' => 'btn-success',
        'secondary' => 'btn-secondary',
        'outline' => 'btn-outline',
        default => 'btn-primary'
    };
@endphp

<button 
    type="{{ $buttonType }}" 
    class="{{ $typeClass }} {{ $sizeClass }} {{ $blockClass }} {{ $loading ? 'btn-loading' : '' }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes }}>
    @if($loading)
        <span class="spinner-border"></span>
    @endif
    {{ $slot }}
</button>
