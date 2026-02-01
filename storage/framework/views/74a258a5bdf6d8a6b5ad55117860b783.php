<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="Sistem Manajemen Peserta PPMHA">
    <title><?php echo $__env->yieldContent('title', 'PPMHA - Sistem Manajemen Peserta'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css?v=' . time())); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="<?php echo $__env->yieldContent('body_class', ''); ?>">
    <header>
        <nav>
            <div class="logo">
                <div class="sun-mini">
                    <img src="<?php echo e(asset('img/logo.png')); ?>" alt="Logo">
                </div>
                <div class="logo-text">
                    <h1><?php echo e($appSettings['title_text'] ?? 'PPMHA'); ?></h1>
                    <span class="text-xs font-bold uppercase tracking-wider text-muted">
                        <?php echo e($appSettings['subtitle_text'] ?? 'Manajemen Peserta'); ?>

                    </span>
                </div>
            </div>
            
            <?php if(auth()->guard()->check()): ?>
            <div class="user-profile-mini">
                <div class="text-right d-none d-md-block">
                    <div class="font-bold text-sm"><?php echo e(auth()->user()->name); ?></div>
                    <div class="text-xs text-muted"><?php echo e(ucfirst(auth()->user()->role->value ?? auth()->user()->role)); ?></div>
                </div>
                <div class="avatar-circle">
                    <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                </div>
            </div>
            <?php endif; ?>
        </nav>
    </header>
    
    <?php if(auth()->guard()->check()): ?>
    <aside class="sidebar">
        <div class="sidebar-nav">
            <?php
                $userRoleValue = (auth()->user()->role instanceof \App\Enums\UserRole) ? auth()->user()->role->value : auth()->user()->role;
            ?>
            <?php if($userRoleValue === 'induk'): ?>
                <a href="<?php echo e(route('dashboard.admin')); ?>" class="sidebar-item <?php echo e(request()->routeIs('dashboard.admin') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('keseluruhan.peserta')); ?>" class="sidebar-item <?php echo e(request()->routeIs('keseluruhan.peserta') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">👥</span>
                    <span>Data Peserta</span>
                </a>
                <a href="<?php echo e(route('tambah.user')); ?>" class="sidebar-item <?php echo e(request()->routeIs('tambah.user') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">👤</span>
                    <span>Kelola User</span>
                </a>
                <a href="<?php echo e(route('tambah.daerah')); ?>" class="sidebar-item <?php echo e(request()->routeIs('tambah.daerah') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">🌍</span>
                    <span>Kelola Daerah</span>
                </a>
                <a href="<?php echo e(route('pengaturan')); ?>" class="sidebar-item <?php echo e(request()->routeIs('pengaturan') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">⚙️</span>
                    <span>Pengaturan</span>
                </a>
            <?php elseif($userRoleValue === 'daerah'): ?>
                <a href="<?php echo e(route('dashboard.daerah')); ?>" class="sidebar-item <?php echo e(request()->routeIs('dashboard.daerah') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('keseluruhan.peserta')); ?>" class="sidebar-item <?php echo e(request()->routeIs('keseluruhan.peserta') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">📊</span>
                    <span>Data Peserta</span>
                </a>
                <a href="<?php echo e(route('pengaturan')); ?>" class="sidebar-item <?php echo e(request()->routeIs('pengaturan') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">⚙️</span>
                    <span>Profil Saya</span>
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('dashboard.pengunjung')); ?>" class="sidebar-item <?php echo e(request()->routeIs('dashboard.pengunjung') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">📋</span>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('keseluruhan.peserta')); ?>" class="sidebar-item <?php echo e(request()->routeIs('keseluruhan.peserta') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">🌍</span>
                    <span>Semua Peserta</span>
                </a>
                <a href="<?php echo e(route('pengaturan')); ?>" class="sidebar-item <?php echo e(request()->routeIs('pengaturan') ? 'active' : ''); ?>">
                    <span class="sidebar-icon">⚙️</span>
                    <span>Profil</span>
                </a>
            <?php endif; ?>
        </div>
        
        <div class="sidebar-footer">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-item" style="color: var(--danger);">
                <span class="sidebar-icon">🚪</span>
                <span>Keluar Sistem</span>
            </a>
            <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form" class="d-none">
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </aside>
    <?php endif; ?>

    <?php if(auth()->guard()->check()): ?>
    <div class="bottom-nav">
        <?php
            $userRoleValue = (auth()->user()->role instanceof \App\Enums\UserRole) ? auth()->user()->role->value : auth()->user()->role;
        ?>
        <?php if($userRoleValue === 'induk'): ?>
            <a href="<?php echo e(route('dashboard.admin')); ?>" class="nav-item <?php echo e(request()->routeIs('dashboard.admin') ? 'active' : ''); ?>">
                <span class="nav-icon">📊</span>
                <span class="nav-label">Home</span>
            </a>
            <a href="<?php echo e(route('keseluruhan.peserta')); ?>" class="nav-item <?php echo e(request()->routeIs('keseluruhan.peserta') ? 'active' : ''); ?>">
                <span class="nav-icon">👥</span>
                <span class="nav-label">Data</span>
            </a>
            <a href="<?php echo e(route('pengaturan')); ?>" class="nav-item <?php echo e(request()->routeIs('pengaturan') ? 'active' : ''); ?>">
                <span class="nav-icon">⚙️</span>
                <span class="nav-label">Profil</span>
            </a>
        <?php elseif($userRoleValue === 'daerah'): ?>
            <a href="<?php echo e(route('dashboard.daerah')); ?>" class="nav-item <?php echo e(request()->routeIs('dashboard.daerah') ? 'active' : ''); ?>">
                <span class="nav-icon">🏠</span>
                <span class="nav-label">Home</span>
            </a>
            <a href="<?php echo e(route('keseluruhan.peserta')); ?>" class="nav-item <?php echo e(request()->routeIs('keseluruhan.peserta') ? 'active' : ''); ?>">
                <span class="nav-icon">📊</span>
                <span class="nav-label">Data</span>
            </a>
            <a href="<?php echo e(route('pengaturan')); ?>" class="nav-item <?php echo e(request()->routeIs('pengaturan') ? 'active' : ''); ?>">
                <span class="nav-icon">⚙️</span>
                <span class="nav-label">Profil</span>
            </a>
        <?php else: ?>
            <a href="<?php echo e(route('dashboard.pengunjung')); ?>" class="nav-item <?php echo e(request()->routeIs('dashboard.pengunjung') ? 'active' : ''); ?>">
                <span class="nav-icon">📋</span>
                <span class="nav-label">Home</span>
            </a>
            <a href="<?php echo e(route('keseluruhan.peserta')); ?>" class="nav-item <?php echo e(request()->routeIs('keseluruhan.peserta') ? 'active' : ''); ?>">
                <span class="nav-icon">🌍</span>
                <span class="nav-label">Data</span>
            </a>
            <a href="<?php echo e(route('pengaturan')); ?>" class="nav-item <?php echo e(request()->routeIs('pengaturan') ? 'active' : ''); ?>">
                <span class="nav-icon">⚙️</span>
                <span class="nav-label">Profil</span>
            </a>
        <?php endif; ?>
        
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" class="nav-item">
            <span class="nav-icon">🚪</span>
            <span class="nav-label">Out</span>
        </a>
        <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form-mobile" class="d-none">
            <?php echo csrf_field(); ?>
        </form>
    </div>
    <?php endif; ?>

    <div class="greeting-bar" style="display: <?php echo $__env->yieldContent('show_greeting', 'block'); ?>;">
        <?php echo e($appSettings['greeting_text'] ?? 'Selamat datang di aplikasi PPMHA.'); ?>

    </div>

    <main class="konten fade-in">
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <span>✅</span>
                <div><?php echo e(session('success')); ?></div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <span>❌</span>
                <div><?php echo e(session('error')); ?></div>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <span>⚠️</span>
                <div>
                    <ul style="margin:0; padding-left: 20px;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="main-footer" align="center">
        <p>&copy; 2026 PPMHA. All rights reserved.</p>
    </footer>

    <a href="https://wa.me/<?php echo e(str_replace('+', '', str_replace(' ', '', $appSettings['whatsapp_number'] ?? '628123456789'))); ?>" 
       class="floating-wa" 
       target="_blank" 
       rel="noopener noreferrer"
       aria-label="Chat di WhatsApp">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
    </a>
    
    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
</body>
</html>

<?php /**PATH C:\test\apk\mangkatan\resources\views/layouts/app.blade.php ENDPATH**/ ?>