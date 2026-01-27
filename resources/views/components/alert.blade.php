@props([
    'type' => 'success',
    'message' => '',
    'icon' => true,
    'dismissible' => true
])

@php
    $iconMap = [
        'success' => '✅',
        'danger' => '❌',
        'warning' => '⚠️',
        'info' => 'ℹ️'
    ];
    $displayIcon = $iconMap[$type] ?? '✅';
@endphp

<div class="alert alert-{{ $type }}" 
     {{ $dismissible ? 'data-dismiss="5000"' : 'data-persist="true"' }}
     role="alert">
    @if($icon)
        <span class="alert-icon">{{ $displayIcon }}</span>
    @endif
    <div class="alert-content">
        {{ $message ?: $slot }}
    </div>
</div>
