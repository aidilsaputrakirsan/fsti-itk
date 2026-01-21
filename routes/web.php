<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Import semua controller yang relevan
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\AchievementsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\PublicAchievementController;
use App\Http\Controllers\PublicProfileController; // <-- Import controller baru
use App\Models\Post;
use App\Models\Achievement;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --- KELOMPOK ROUTE PUBLIK ---

// Route untuk ganti bahasa
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');


Route::get('/', function () {
    $latestPosts = Post::where('category', '!=', 'Prestasi')
        ->where('status', 'Terbitkan')
        ->latest('published_at')
        ->take(3)
        ->get();

    $latestAchievements = Achievement::latest()->take(3)->get();

    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'latestPosts' => $latestPosts,
        'latestAchievements' => $latestAchievements, // Data ini sekarang berasal dari model Achievement
    ]);
})->name('home');

// Route untuk menampilkan daftar semua berita
Route::get('/berita', [PublicPostController::class, 'index'])->name('berita.index');

// Route untuk menampilkan satu berita berdasarkan slug-nya
Route::get('/berita/{post:slug}', [PublicPostController::class, 'show'])->name('berita.show');

// PERUBAHAN: Tambahkan route untuk halaman Prestasi Mahasiswa
Route::get('/prestasi', [PublicAchievementController::class, 'index'])->name('prestasi.index');


// --- KELOMPOK ROUTE UNTUK ADMIN ---
// Semua URL di sini akan diawali dengan /admin/ dan memerlukan login
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Route untuk Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource Routes untuk CRUD Posts (Berita) dan Achievements (Prestasi)
    Route::resource('/posts', AdminPostController::class);
    Route::resource('/achievements', AchievementsController::class);

    // Route untuk Impor & Ekspor Prestasi
    Route::post('/achievements/import', [AchievementsController::class, 'import'])->name('achievements.import');
    Route::get('/achievements/export', [AchievementsController::class, 'export'])->name('achievements.export');

    // --- MODUL TAMBAHAN (Admin) ---
    Route::resource('/ppid', \App\Http\Controllers\Admin\PpidController::class);
    Route::resource('/integrity-zones', \App\Http\Controllers\Admin\IntegrityZoneController::class);
    Route::resource('/alumni', \App\Http\Controllers\Admin\AlumniController::class);
    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('/satisfaction-surveys', \App\Http\Controllers\Admin\SatisfactionSurveyController::class);
    Route::resource('/internal-services', \App\Http\Controllers\Admin\InternalServiceController::class);
    
    // Profil Module
    Route::resource('/static-pages', \App\Http\Controllers\Admin\StaticPageController::class)->only(['index', 'edit', 'update']);
    Route::resource('/staff', \App\Http\Controllers\Admin\StaffController::class);
});

// --- MODUL TAMBAHAN (Publik) ---
use App\Http\Controllers\PublicAdditionalController;

Route::get('/ppid', [PublicAdditionalController::class, 'ppid'])->name('ppid.index');
Route::get('/zona-integritas', [PublicAdditionalController::class, 'zonaIntegritas'])->name('zona-integritas.index');
Route::get('/alumni', [PublicAdditionalController::class, 'alumni'])->name('alumni.index');
Route::get('/survei-kepuasan', [PublicAdditionalController::class, 'survei'])->name('survei.index');
Route::post('/survei-kepuasan', [PublicAdditionalController::class, 'storeSurvei'])->name('survei.store');
Route::get('/layanan-internal', [PublicAdditionalController::class, 'layanan'])->name('layanan.index');


// --- KELOMPOK ROUTE UNTUK AUTENTIKASI ---

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Arahkan /dashboard default Laravel ke dashboard admin kita
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk Visi & Misi
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
    return Inertia::render('Public/Kontak');
})->name('kontak');


// Impor route-route autentikasi standar (login, register, dll.)
require __DIR__ . '/auth.php';
