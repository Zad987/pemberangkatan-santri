@props([
    'buttonType' => 'button',
    'size' => 'md',
    'variant' => 'primary',
    'block' => false,
    'disabled' => false,
    'loading' => false,
])

<button 
    type="{{ $buttonType }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => "btn-$variant btn-$size" . ($block ? ' w-full' : '') . ($loading ? ' btn-loading' : '') . ' btn']) }}
>
    @if($loading)
        <span class="spinner-border"></span>
    @endif
    {{ $slot }}
</button>