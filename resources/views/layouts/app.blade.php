<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem Manajemen Peserta PPMHA">
    <title>@yield('title', 'PPMHA - Sistem Manajemen Peserta')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css?v=' . time()) }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="@yield('body_class', '')">
    <header>
        <nav>
            <div class="logo">
                <div class="sun-mini">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo">
                </div>
                <div class="logo-text">
                    <h1>{{ $appSettings['title_text'] ?? 'PPMHA' }}</h1>
                    <span class="text-xs font-bold uppercase tracking-wider text-muted">
                        {{ $appSettings['subtitle_text'] ?? 'Manajemen Peserta' }}
                    </span>
                </div>
            </div>
            
            @auth
            <div class="user-profile-mini">
                <div class="text-right d-none d-md-block">
                    <div class="font-bold text-sm">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-muted">{{ ucfirst(auth()->user()->role->value ?? auth()->user()->role) }}</div>
                </div>
                <div class="avatar-circle">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
            @endauth
        </nav>
    </header>
    
    @auth
    <aside class="sidebar">
        <div class="sidebar-nav">
            @if(auth()->user()->role === 'induk')
                <a href="{{ route('dashboard.admin') }}" class="sidebar-item {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                    <span class="sidebar-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('keseluruhan.peserta') }}" class="sidebar-item {{ request()->routeIs('keseluruhan.peserta') ? 'active' : '' }}">
                    <span class="sidebar-icon">👥</span>
                    <span>Data Peserta</span>
                </a>
                <a href="{{ route('tambah.user') }}" class="sidebar-item {{ request()->routeIs('tambah.user') ? 'active' : '' }}">
                    <span class="sidebar-icon">👤</span>
                    <span>Kelola User</span>
                </a>
                <a href="{{ route('tambah.daerah') }}" class="sidebar-item {{ request()->routeIs('tambah.daerah') ? 'active' : '' }}">
                    <span class="sidebar-icon">🌍</span>
                    <span>Kelola Daerah</span>
                </a>
                <a href="{{ route('pengaturan') }}" class="sidebar-item {{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <span class="sidebar-icon">⚙️</span>
                    <span>Pengaturan</span>
                </a>
            @elseif(auth()->user()->role === 'daerah')
                <a href="{{ route('dashboard.daerah') }}" class="sidebar-item {{ request()->routeIs('dashboard.daerah') ? 'active' : '' }}">
                    <span class="sidebar-icon">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('keseluruhan.peserta') }}" class="sidebar-item {{ request()->routeIs('keseluruhan.peserta') ? 'active' : '' }}">
                    <span class="sidebar-icon">📊</span>
                    <span>Data Peserta</span>
                </a>
                <a href="{{ route('pengaturan') }}" class="sidebar-item {{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <span class="sidebar-icon">⚙️</span>
                    <span>Profil Saya</span>
                </a>
            @else
                <a href="{{ route('dashboard.pengunjung') }}" class="sidebar-item {{ request()->routeIs('dashboard.pengunjung') ? 'active' : '' }}">
                    <span class="sidebar-icon">📋</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('keseluruhan.peserta') }}" class="sidebar-item {{ request()->routeIs('keseluruhan.peserta') ? 'active' : '' }}">
                    <span class="sidebar-icon">🌍</span>
                    <span>Semua Peserta</span>
                </a>
                <a href="{{ route('pengaturan') }}" class="sidebar-item {{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <span class="sidebar-icon">⚙️</span>
                    <span>Profil</span>
                </a>
            @endif
        </div>
        
        <div class="sidebar-footer">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-item" style="color: var(--danger);">
                <span class="sidebar-icon">🚪</span>
                <span>Keluar Sistem</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">
                @csrf
            </form>
        </div>
    </aside>
    @endauth

    @auth
    <div class="bottom-nav">
        @if(auth()->user()->role === 'induk')
            <a href="{{ route('dashboard.admin') }}" class="nav-item {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                <span class="nav-icon">📊</span>
                <span class="nav-label">Home</span>
            </a>
            <a href="{{ route('keseluruhan.peserta') }}" class="nav-item {{ request()->routeIs('keseluruhan.peserta') ? 'active' : '' }}">
                <span class="nav-icon">👥</span>
                <span class="nav-label">Data</span>
            </a>
            <a href="{{ route('pengaturan') }}" class="nav-item {{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                <span class="nav-icon">⚙️</span>
                <span class="nav-label">Profil</span>
            </a>
        @elseif(auth()->user()->role === 'daerah')
            <a href="{{ route('dashboard.daerah') }}" class="nav-item {{ request()->routeIs('dashboard.daerah') ? 'active' : '' }}">
                <span class="nav-icon">🏠</span>
                <span class="nav-label">Home</span>
            </a>
            <a href="{{ route('keseluruhan.peserta') }}" class="nav-item {{ request()->routeIs('keseluruhan.peserta') ? 'active' : '' }}">
                <span class="nav-icon">📊</span>
                <span class="nav-label">Data</span>
            </a>
            <a href="{{ route('pengaturan') }}" class="nav-item {{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                <span class="nav-icon">⚙️</span>
                <span class="nav-label">Profil</span>
            </a>
        @else
            <a href="{{ route('dashboard.pengunjung') }}" class="nav-item {{ request()->routeIs('dashboard.pengunjung') ? 'active' : '' }}">
                <span class="nav-icon">📋</span>
                <span class="nav-label">Home</span>
            </a>
            <a href="{{ route('keseluruhan.peserta') }}" class="nav-item {{ request()->routeIs('keseluruhan.peserta') ? 'active' : '' }}">
                <span class="nav-icon">🌍</span>
                <span class="nav-label">Data</span>
            </a>
            <a href="{{ route('pengaturan') }}" class="nav-item {{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                <span class="nav-icon">⚙️</span>
                <span class="nav-label">Profil</span>
            </a>
        @endif
        
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" class="nav-item">
            <span class="nav-icon">🚪</span>
            <span class="nav-label">Out</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile" class="d-none">
            @csrf
        </form>
    </div>
    @endauth

    <div class="greeting-bar" style="display: @yield('show_greeting', 'block');">
        {{ $appSettings['greeting_text'] ?? 'Selamat datang di aplikasi PPMHA.' }}
    </div>

    <main class="konten fade-in">
        @if(session('success'))
            <div class="alert alert-success">
                <span>✅</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <span>❌</span>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <span>⚠️</span>
                <div>
                    <ul style="margin:0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="main-footer" align="center">
        <p>&copy; 2026 PPMHA. All rights reserved.</p>
    </footer>

    <a href="https://wa.me/{{ str_replace('+', '', str_replace(' ', '', $appSettings['whatsapp_number'] ?? '628123456789')) }}" 
       class="floating-wa" 
       target="_blank" 
       rel="noopener noreferrer"
       aria-label="Chat di WhatsApp">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
    </a>
    
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>

