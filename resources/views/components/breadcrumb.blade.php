<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                @if($breadcrumb['url'] && !$loop->last)
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['icon'] ?? '' }} {{ $breadcrumb['title'] }}</a>
                @else
                    <span>{{ $breadcrumb['icon'] ?? '' }} {{ $breadcrumb['title'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>