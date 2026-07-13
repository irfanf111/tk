<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\RegistrationForm;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\User\PpdbController as UserPpdbController;
use App\Http\Controllers\Admin\PpdbAdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialiteController;

// ─── Auth: Login, Register, Logout ────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── SSO Google ────────────────────────────────────────────────────────────
Route::prefix('auth/google')->name('auth.google.')->group(function () {
    Route::get('redirect', [SocialiteController::class, 'redirectToGoogle'])->name('redirect');
    Route::get('callback', [SocialiteController::class, 'handleGoogleCallback'])->name('callback');
});

// ─── Halaman Publik ─────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');

// ─── Laman Berita ────────────────────────────────────────────────────────────
Route::get('/artikel', [ArticleController::class, 'index'])->name('berita.index');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('berita.show');

Route::redirect('/register-student', '/ppdb/daftar')->name('register.create');

Route::get('/profil-sekolah', function () {
    $profile = \App\Models\SchoolProfile::first();
    $recentArticles = \App\Models\Article::latest('published_at')->take(4)->get();
    return view('pages.profil-sekolah', compact('profile', 'recentArticles'));
})->name('profil-sekolah');

Route::get('/visi-misi', function () {
    $visionMission = \App\Models\VisionMission::first();
    $recentArticles = \App\Models\Article::latest('published_at')->take(4)->get();
    return view('pages.visi-misi', compact('visionMission', 'recentArticles'));
})->name('visi-misi');

Route::get('/identitas-sekolah', function () {
    $identity = \App\Models\SchoolIdentity::first();
    $recentArticles = \App\Models\Article::latest('published_at')->take(4)->get();
    return view('pages.identitas-sekolah', compact('identity', 'recentArticles'));
})->name('identitas-sekolah');

// ─── LPAD: Laporan Perkembangan Anak Didik ─────────────────────────────────
Route::prefix('lpad')->name('reports.')->group(function () {
    Route::get('/buat', [ReportController::class, 'create'])->name('create');
    Route::post('/simpan', [ReportController::class, 'store'])->name('store');
    Route::get('/{id}/pdf', [ReportController::class, 'exportPdf'])->name('pdf');
});

// ─── PPDB: Penerimaan Peserta Didik Baru (publik, tanpa login) ─────────────
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/daftar', [PpdbController::class, 'create'])->name('create');
    Route::post('/daftar', [PpdbController::class, 'store'])->name('store');
    Route::get('/{id}/sukses', [PpdbController::class, 'success'])->name('success');
    Route::get('/{id}/cetak-pdf', [PpdbController::class, 'exportPdf'])->name('pdf');
});

// ─── PPDB User Portal ──────────────────────────────────────────────────────
// Middleware 'auth' WAJIB di depan biar sistem ngecek login dulu, baru ngecek role!
Route::prefix('portal/ppdb')
    ->name('ppdb.user.')
    ->middleware(['auth', 'role.user'])
    ->group(function () {
        Route::get('/', [UserPpdbController::class, 'index'])->name('index');
        Route::get('/formulir', [UserPpdbController::class, 'create'])->name('create');
        Route::get('/formulir/edit', [UserPpdbController::class, 'edit'])->name('edit');
        Route::post('/formulir', [UserPpdbController::class, 'store'])->name('store');
        Route::post('/kirim', [UserPpdbController::class, 'submit'])->name('submit');
    });

// ─── Cetak PPDB (dipanggil dari Filament Admin Panel) ──────────────────────
// Route ini diakses via tombol "Cetak" di PpdbRegistrationResource.
// Dilindungi middleware 'role.admin' agar hanya admin yang bisa membuka.
Route::get('/admin/ppdb/{id}/cetak', [PpdbAdminController::class, 'cetak'])
    ->name('admin.ppdb.cetak')
    ->middleware(['role.admin']);

Route::get('/admin/ppdb/{id}/pdf', [PpdbAdminController::class, 'exportPdf'])
    ->name('admin.ppdb.pdf')
    ->middleware(['role.admin']);

// ─── Export PDF Rapor/LPAD (dipanggil dari Filament Admin Panel) ────────────
// Dilindungi middleware 'role.admin'. Memanggil ReportController::exportPdf.
Route::get('/admin/rapor/{id}/pdf', [ReportController::class, 'exportPdf'])
    ->name('admin.rapor.pdf')
    ->middleware(['role.admin']);