<nav aria-label="breadcrumb" class="breadcrumb-container">
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb['url'])
                <li class="breadcrumb-item">
                    <a href="{{ $breadcrumb['url'] }}" class="breadcrumb-link">
                        @if(isset($breadcrumb['icon']))
                            <span class="breadcrumb-icon">{{ $breadcrumb['icon'] }}</span>
                        @endif
                        {{ $breadcrumb['title'] }}
                    </a>
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">
                    @if(isset($breadcrumb['icon']))
                        <span class="breadcrumb-icon">{{ $breadcrumb['icon'] }}</span>
                    @endif
                    {{ $breadcrumb['title'] }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>

<style>
.breadcrumb-container {
    padding: 0.75rem 0;
    margin-bottom: 1rem;
    background: var(--bg-card);
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.breadcrumb {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    margin: 0;
    padding: 0;
    font-size: 0.875rem;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: var(--text-muted);
    margin: 0 0.5rem;
    font-weight: bold;
}

.breadcrumb-link {
    text-decoration: none;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: 0.25rem;
    transition: color 0.2s ease;
}

.breadcrumb-link:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: var(--text-main);
    font-weight: 600;
}

.breadcrumb-icon {
    font-size: 0.8rem;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .breadcrumb-container {
        padding: 0.5rem;
        margin-bottom: 0.75rem;
    }
    
    .breadcrumb {
        font-size: 0.8rem;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        margin: 0 0.25rem;
    }
}
</style>