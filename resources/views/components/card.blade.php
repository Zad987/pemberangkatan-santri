@props([
    'title' => null,
    'icon' => null,
    'class' => null
])

<div class="data-card fade-in {{ $class }}">
    @if($title || $icon)
        <div class="section-header px-4 pt-4 mb-0">
            <h3 class="heading-4 m-0">
                @if($icon) <span class="me-2">{{ $icon }}</span> @endif
                {{ $title }}
            </h3>
        </div>
    @endif
    
    <div class="p-4">
        {{ $slot }}
    </div>
</div>