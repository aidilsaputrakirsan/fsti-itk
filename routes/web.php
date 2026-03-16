<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Import Controllers
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\AchievementsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\PublicAchievementController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\PublicAdditionalController;
use App\Models\Post;
use App\Models\Achievement;

// --- 1. KELOMPOK ROUTE ADMIN  ---
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/posts', AdminPostController::class);
    Route::resource('/achievements', AchievementsController::class);
    Route::post('/achievements/import', [AchievementsController::class, 'import'])->name('achievements.import');
    Route::get('/achievements/export', [AchievementsController::class, 'export'])->name('achievements.export');

    // Rute untuk Zona Integritas Admin
    Route::prefix('zona-integritas')->name('zi.')->group(function () {
        // Pengaturan Profil
        Route::get('/profil', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'profileEdit'])->name('profile.edit');
        Route::post('/profil', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'profileUpdate'])->name('profile.update');

        // Kelola Dokumen (CRUD Lengkap)
        Route::get('/dokumen', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentIndex'])->name('document.index');
        Route::get('/dokumen/create', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentCreate'])->name('document.create');
        Route::post('/dokumen', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentStore'])->name('document.store');
        Route::get('/dokumen/{id}/edit', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentEdit'])->name('document.edit');
        Route::post('/dokumen/{id}', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentUpdate'])->name('document.update');
        Route::delete('/dokumen/{id}', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentDestroy'])->name('document.destroy');
    });

    // Modul PPID Admin
    Route::resource('/ppid', \App\Http\Controllers\Admin\PpidController::class);
    Route::resource('/kategori-ppid', \App\Http\Controllers\Admin\KategoriPpidController::class);

    Route::resource('/alumni', \App\Http\Controllers\Admin\AlumniController::class);
    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('/satisfaction-surveys', \App\Http\Controllers\Admin\SatisfactionSurveyController::class);
    Route::resource('/internal-services', \App\Http\Controllers\Admin\InternalServiceController::class);
    Route::resource('/static-pages', \App\Http\Controllers\Admin\StaticPageController::class)->only(['index', 'edit', 'update']);
    Route::resource('/staff', \App\Http\Controllers\Admin\StaffController::class);
});


// --- 2. KELOMPOK ROUTE PUBLIK ---
Route::get('/', function () {
    $latestPosts = Post::where('category', '!=', 'Prestasi')->where('status', 'Terbitkan')->latest('published_at')->take(3)->get();
    $latestAchievements = Achievement::latest()->take(3)->get();
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'latestPosts' => $latestPosts,
        'latestAchievements' => $latestAchievements,
    ]);
})->name('home');

Route::get('/berita', [PublicPostController::class, 'index'])->name('berita.index');
Route::get('/berita/{post:slug}', [PublicPostController::class, 'show'])->name('berita.show');
Route::get('/prestasi', [PublicAchievementController::class, 'index'])->name('prestasi.index');

// PPID Publik
Route::get('/ppid', [PublicAdditionalController::class, 'ppid'])->name('public.ppid.index');
Route::get('/ppid/informasi/{slug}', [PublicAdditionalController::class, 'showJenis'])->name('public.ppid.show');

// Layanan Publik Lainnya
Route::get('/zona-integritas', [PublicAdditionalController::class, 'zonaIntegritas'])->name('zona-integritas.index');
Route::get('/alumni', [PublicAdditionalController::class, 'alumni'])->name('alumni.index');
Route::get('/survei-kepuasan', [PublicAdditionalController::class, 'survei'])->name('survei.index');
Route::post('/survei-kepuasan', [PublicAdditionalController::class, 'storeSurvei'])->name('survei.store');
Route::get('/layanan-internal', [PublicAdditionalController::class, 'layanan'])->name('layanan.index');


// --- 3. KELOMPOK AUTH ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// --- 4. Profil & Prodi (Publik) ---
Route::get('/profil/visi-misi', [PublicProfileController::class, 'visiMisi'])->name('visi-misi');
Route::get('/profil/bagan-organisasi', [PublicProfileController::class, 'baganOrganisasi'])->name('bagan-organisasi');
Route::get('/profil/pimpinan-fakultas', [PublicProfileController::class, 'pimpinanFakultas'])->name('profil.pimpinan-fakultas');
Route::get('/profil/pimpinan-jurusan', [PublicProfileController::class, 'pimpinanJurusan'])->name('profil.pimpinan-jurusan');
Route::get('/profil/pimpinan-prodi', [PublicProfileController::class, 'pimpinanProdi'])->name('profil.pimpinan-prodi');
Route::get('/profil/pimpinan-laboratorium', [PublicProfileController::class, 'pimpinanLaboratorium'])->name('profil.pimpinan-laboratorium');
Route::get('/profil/dosen', [PublicProfileController::class, 'dosen'])->name('profil.dosen');
Route::get('/profil/tenaga-kependidikan', [PublicProfileController::class, 'tendik'])->name('profil.tenaga-kependidikan');
Route::get('/program-studi/matematika', function () {
    return Inertia::render('Public/ProgramStudi/Matematika');
})->name('prodi.matematika');
Route::get('/kontak', function () {
    return Inertia::render('Public/Profil/Kontak');
})->name('kontak');

require __DIR__ . '/auth.php';
