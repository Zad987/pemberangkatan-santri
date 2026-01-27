@props([
    'title' => '',
    'subtitle' => null,
    'actions' => null
])

<div class="section-header">
    <h2 class="section-title">
        {{ $title }}
        @if($subtitle)
            <small class="text-muted d-block mt-1">{{ $subtitle }}</small>
        @endif
    </h2>
    
    <div class="section-actions">
        {{ $actions ?? '' }}
    </div>
</div>