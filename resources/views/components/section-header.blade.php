@props([
    'title' => '',
    'icon' => '',
    'action' => ''
])

<div class="section-header fade-in">
    <div>
        @if($icon)
            <span style="margin-right: 8px;">{{ $icon }}</span>
        @endif
        <h2>{{ $title ?: $slot }}</h2>
    </div>
    @if($action)
        {{ $action }}
    @endif
</div>
