<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\RegistrationForm;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\AgendaController;
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

// ─── PPDB: Penerimaan Peserta Didik Baru ───────────────────────────────────
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/daftar', [PpdbController::class, 'create'])->name('create');
    Route::post('/daftar', [PpdbController::class, 'store'])->name('store');
    Route::get('/{id}/sukses', [PpdbController::class, 'success'])->name('success');
    Route::get('/{id}/cetak-pdf', [PpdbController::class, 'exportPdf'])->name('pdf');
});

// ─── PPDB User Portal (Memerlukan Login & Email Verified) ──────────────────
// Ini adalah alur PPDB baru yang terhubung ke akun user.
// Terpisah dari route lama (/ppdb/daftar) agar backward compatible.
Route::prefix('portal/ppdb')
    ->name('ppdb.user.')
    ->middleware(['auth']) // 'verified' dihapus karena menggunakan auth manual tanpa email verifikasi
    ->group(function () {

        // Dashboard: tampilkan status pendaftaran user
        Route::get('/', [UserPpdbController::class, 'index'])
            ->name('index');

        // Form pengisian formulir pendaftaran baru (create) atau lanjut isi (edit)
        Route::get('/formulir', [UserPpdbController::class, 'create'])
            ->name('create');

        // Alias edit → mengarah ke method yang sama dengan create (form tunggal)
        Route::get('/formulir/edit', [UserPpdbController::class, 'edit'])
            ->name('edit');

        // Simpan / Update data sebagai DRAFT (multi-tabel, dengan transaction)
        Route::post('/formulir', [UserPpdbController::class, 'store'])
            ->name('store');

        // Finalisasi: ubah status draft → submitted setelah validasi kelengkapan
        Route::post('/kirim', [UserPpdbController::class, 'submit'])
            ->name('submit');
    });

// ─── PPDB Admin Panel ──────────────────────────────────────────────────────
// TODO: Tambahkan middleware role admin di sini, contoh:
//   ->middleware(['auth', 'role:admin'])   jika pakai custom middleware
//   ->middleware(['auth', 'can:admin'])    jika pakai Gate/Policy
Route::prefix('admin/ppdb')
    ->name('admin.ppdb.')
    ->middleware(['auth']) // ← ganti sesuai middleware admin Anda
    ->group(function () {

        // Daftar semua pendaftar — support filter ?status=submitted|verified|dll
        Route::get('/', [PpdbAdminController::class, 'index'])->name('index');

        // Detail lengkap satu pendaftar (siswa + ortu + dokumen)
        Route::get('/{id}', [PpdbAdminController::class, 'show'])->name('show');

        // Verifikasi berkas: submitted → verified | rejected
        Route::put('/{id}/verify', [PpdbAdminController::class, 'verify'])->name('verify');

        // Keputusan akhir: verified → accepted | not_accepted
        Route::put('/{id}/decide', [PpdbAdminController::class, 'decide'])->name('decide');

        // Cetak rekap data pendaftaran (halaman print preview)
        Route::get('/{id}/cetak', [PpdbAdminController::class, 'cetak'])->name('cetak');
    });

Route::prefix('auth/google')->name('auth.google.')->group(function () {
    Route::get('redirect', [SocialiteController::class, 'redirectToGoogle'])->name('redirect');
    Route::get('callback', [SocialiteController::class, 'handleGoogleCallback'])->name('callback');
});