<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Root route - redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('rate.limit:login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', function () {
    return redirect()->route('login');
});
Route::get('/jadi-pengunjung', [AuthController::class, 'becomeVisitor'])->name('jadi.pengunjung');

// Protected Routes - Require Authentication
Route::middleware(['auth', 'rate.limit:api'])->group(function () {
    Route::middleware(['check.session'])->group(function () {
        Route::get('/dashboard/pengunjung', [DashboardController::class, 'visitor'])->name('dashboard.pengunjung');
        Route::get('/keseluruhan/peserta', [DashboardController::class, 'keseluruhan'])->name('keseluruhan.peserta');
        Route::get('/detail/peserta/{id}', [ParticipantController::class, 'show'])->name('detail.peserta');

        // Admin-only routes
        Route::middleware(['admin'])->group(function () {
            Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
            Route::get('/admin/share-whatsapp', [DashboardController::class, 'shareToWhatsApp'])->name('admin.share.whatsapp')->middleware('rate.limit:export');

            Route::get('/tambah/user', [UserController::class, 'index'])->name('tambah.user');
            Route::post('/tambah/user', [UserController::class, 'store'])->name('user.store');
            Route::get('/detail/user/{id}', [UserController::class, 'show'])->name('detail.user');
            Route::put('/detail/user/{id}', [UserController::class, 'update'])->name('user.update');
            Route::put('/detail/user/{id}/password', [UserController::class, 'updatePassword'])->name('user.password.update');
            Route::delete('/detail/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
            Route::post('/detail/user/{id}/logout-device', [UserController::class, 'logoutDevice'])->name('user.logout.device');

            Route::get('/tambah/kategori', [CategoryController::class, 'index'])->name('tambah.kategori');
            Route::post('/tambah/kategori', [CategoryController::class, 'store'])->name('kategori.store');
            Route::get('/detail/kategori/{id}', [CategoryController::class, 'show'])->name('detail.kategori');
            Route::put('/detail/kategori/{id}', [CategoryController::class, 'update'])->name('kategori.update');
            Route::delete('/detail/kategori/{id}', [CategoryController::class, 'destroy'])->name('kategori.destroy');

            Route::get('/tambah/daerah', [RegionController::class, 'index'])->name('tambah.daerah');
            Route::post('/tambah/daerah', [RegionController::class, 'store'])->name('daerah.store');
            Route::get('/detail/daerah/{id}', [RegionController::class, 'show'])->name('detail.daerah');
            Route::put('/detail/daerah/{id}', [RegionController::class, 'update'])->name('daerah.update');
            Route::delete('/detail/daerah/{id}', [RegionController::class, 'destroy'])->name('daerah.destroy');

            Route::get('/pengaturan', [SettingsController::class, 'index'])->name('pengaturan');
            Route::post('/pengaturan', [SettingsController::class, 'update']);

            // PDF Routes
            Route::get('/pdf/participants/all', [PdfController::class, 'downloadAllParticipants'])->name('pdf.participants.all')->middleware('rate.limit:export');
            Route::get('/pdf/category/{id}', [PdfController::class, 'downloadCategoryReport'])->name('pdf.category.report')->middleware('rate.limit:export');
            Route::get('/pdf/region/{id}', [PdfController::class, 'downloadRegionReport'])->name('pdf.region.report')->middleware('rate.limit:export');
            Route::get('/pdf/admin', [PdfController::class, 'downloadAdminReport'])->name('pdf.admin.report')->middleware('rate.limit:export');
        });

        // Daerah-only routes (can also be accessed by admins)
        Route::middleware(['daerah'])->group(function () {
            Route::get('/dashboard/daerah', [DashboardController::class, 'daerah'])->name('dashboard.daerah');

            Route::post('/tambah/peserta', [ParticipantController::class, 'store'])->name('tambah.peserta');
            Route::get('/peserta/{id}/edit', [ParticipantController::class, 'edit'])->name('peserta.edit');
            Route::put('/peserta/{id}', [ParticipantController::class, 'updateDetails'])->name('peserta.update');
            Route::delete('/peserta/{id}', [ParticipantController::class, 'destroy'])->name('peserta.destroy');
            Route::put('/peserta/{id}/payment', [ParticipantController::class, 'updatePayment'])->name('update.payment')->middleware('rate.limit:payment');
            Route::delete('/payment/{id}', [ParticipantController::class, 'destroyPayment'])->name('payment.destroy');
        });
    });
});
