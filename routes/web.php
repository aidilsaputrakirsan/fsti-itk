<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\AchievementsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SurveyCategoryController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\TentangFakultasController;
use App\Http\Controllers\Admin\StudyProgramController as AdminStudyProgramController;
use App\Http\Controllers\Admin\BeasiswaController as AdminBeasiswaController;

use App\Http\Controllers\Public\PublicPostController;
use App\Http\Controllers\Public\PublicAchievementController;
use App\Http\Controllers\Public\PublicProfileController;
use App\Http\Controllers\Public\PublicStaffController;
use App\Http\Controllers\Public\PublicPpidController;
use App\Http\Controllers\Public\PublicZonaIntegritasController;
use App\Http\Controllers\Public\PublicSurveiController;
use App\Http\Controllers\Public\PublicProgramStudiController;
use App\Http\Controllers\Public\PublicKegiatanMahasiswaController;
use App\Http\Controllers\Public\PublicBeasiswaController;
use App\Http\Controllers\Public\PublicAlumniController;

use App\Models\Post;
use App\Models\Achievement;

// ==============================================================================
// 1. KELOMPOK ROUTE ADMIN
// ==============================================================================
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/posts', AdminPostController::class);
    Route::resource('/achievements', AchievementsController::class);

    Route::resource('kegiatan-mahasiswa', \App\Http\Controllers\Admin\KegiatanMahasiswaController::class);

    Route::resource('beasiswa', AdminBeasiswaController::class);

    Route::resource('/alumni', \App\Http\Controllers\Admin\AlumniController::class)->parameters([
        'alumni' => 'alumnus' // Menghindari pluralisasi yang aneh oleh Laravel (alumnis)
    ]);

    Route::prefix('zona-integritas')->name('zi.')->group(function () {
        Route::get('/profil', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'profileEdit'])->name('profile.edit');
        Route::post('/profil', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'profileUpdate'])->name('profile.update');

        Route::get('/dokumen', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentIndex'])->name('document.index');
        Route::get('/dokumen/create', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentCreate'])->name('document.create');
        Route::post('/dokumen', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentStore'])->name('document.store');
        Route::get('/dokumen/{id}/edit', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentEdit'])->name('document.edit');
        Route::post('/dokumen/{id}', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentUpdate'])->name('document.update');
        Route::delete('/dokumen/{id}', [\App\Http\Controllers\Admin\IntegrityZoneController::class, 'documentDestroy'])->name('document.destroy');
    });

    Route::resource('/ppid', \App\Http\Controllers\Admin\PpidController::class);
    Route::resource('/kategori-ppid', \App\Http\Controllers\Admin\KategoriPpidController::class);
    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);

    Route::resource('/satisfaction-surveys', \App\Http\Controllers\Admin\SatisfactionSurveyController::class);
    Route::get('/survey-categories', [SurveyCategoryController::class, 'index'])->name('survey-categories.index');
    Route::post('/survey-categories', [SurveyCategoryController::class, 'store'])->name('survey-categories.store');
    Route::put('/survey-categories/{surveyCategory}', [SurveyCategoryController::class, 'update'])->name('survey-categories.update');
    Route::delete('/survey-categories/{surveyCategory}', [SurveyCategoryController::class, 'destroy'])->name('survey-categories.destroy');

    Route::resource('/internal-services', \App\Http\Controllers\Admin\InternalServiceController::class);
    Route::resource('/staff', \App\Http\Controllers\Admin\StaffController::class);
    Route::resource('post-categories', PostCategoryController::class)->except(['show']);

    Route::get('/contacts', [\App\Http\Controllers\Admin\ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts', [\App\Http\Controllers\Admin\ContactController::class, 'update'])->name('contacts.update');

    Route::get('/tentang-fakultas', [TentangFakultasController::class, 'edit'])->name('tentang.edit');
    Route::put('/tentang-fakultas', [TentangFakultasController::class, 'update'])->name('tentang.update');

    Route::resource('/study-programs', AdminStudyProgramController::class)->except(['show']);

    Route::resource('/agenda-fakultas', \App\Http\Controllers\Admin\AgendaFakultasController::class);
});


// ==============================================================================
// 2. KELOMPOK ROUTE PUBLIK
// ==============================================================================

Route::get('/', function () {
    $latestPosts = Post::select('posts.*', 'post_categories.name as category')
        ->leftJoin('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
        ->where('post_categories.name', '!=', 'Prestasi')
        ->where('posts.status', 'Terbitkan')
        ->latest('posts.published_at')
        ->take(3)
        ->get();

    $latestAchievements = Achievement::latest()
        ->take(3)
        ->get()
        ->map(fn($item) => [
            'id' => $item->id,
            'student_name' => $item->student_name,
            'student_nim' => $item->student_nim ?? '',
            'study_program' => $item->study_program,
            'title' => $item->title,
            'organizer' => $item->organizer ?? 'FSTI ITK',
            'level' => $item->level,
            'category' => $item->category,
            'year' => $item->year,
            'image_url' => $item->image_path ? asset('storage/' . $item->image_path) : null,
            'certificate_url' => $item->certificate_path ? asset('storage/' . $item->certificate_path) : null,
        ]);

    $tentang = \App\Models\TentangFakultas::first();

    $allProdi = \App\Models\StudyProgram::all();
    $s1 = 0;
    $s2 = 0;

    foreach ($allProdi as $p) {
        $level = $p->level ?? '';
        $name = strtolower($p->name);

        if (strtoupper($level) === 'S1' || (!str_contains($name, 's2') && !str_contains($name, 'magister') && strtoupper($level) !== 'S2')) {
            $s1++;
        } else {
            $s2++;
        }
    }

    $statistik = [
        'dosen' => \App\Models\Staff::where('type', 'Dosen')->where('is_active', true)->count(),
        'tendik' => \App\Models\Staff::where('type', 'Tendik')->where('is_active', true)->count(),
        'prodi_s1' => $s1,
        'prodi_s2' => $s2,
        'prodi_total' => $allProdi->count(),
    ];

    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'latestPosts' => $latestPosts,
        'latestAchievements' => $latestAchievements,
        'tentang' => $tentang ? $tentang->content : null,
        'statistik' => $statistik,
    ]);
})->name('home');

Route::get('/berita', [PublicPostController::class, 'index'])->name('berita.index');
Route::get('/berita/{post:slug}', [PublicPostController::class, 'show'])->name('berita.show');
Route::get('/prestasi', [PublicAchievementController::class, 'index'])->name('prestasi.index');

Route::get('/ppid', [PublicPpidController::class, 'index'])->name('public.ppid.index');
Route::get('/ppid/informasi/{slug}', [PublicPpidController::class, 'show'])->name('public.ppid.show');
Route::get('/zona-integritas', [PublicZonaIntegritasController::class, 'index'])->name('zona-integritas.index');
Route::get('/survei-kepuasan', [PublicSurveiController::class, 'index'])->name('survei.index');
Route::post('/survei-kepuasan', [PublicSurveiController::class, 'store'])->name('survei.store');
Route::get('/layanan-internal', function () {
    $services = \App\Models\InternalService::orderBy('sort_order', 'asc')->get()->map(function ($item) {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'link_url' => $item->link_url,
        ];
    });
    return Inertia::render('Public/Layanan/Index', ['services' => $services]);
})->name('layanan.index');

Route::get('/prodi/{slug}', [PublicProgramStudiController::class, 'show'])->name('public.prodi.show');

Route::get('/profil/tentang', [PublicProfileController::class, 'tentang'])->name('profil.tentang');
Route::get('/profil/bagan-organisasi', [PublicProfileController::class, 'baganOrganisasi'])->name('bagan-organisasi');
Route::get('/kontak', [PublicProfileController::class, 'kontak'])->name('kontak');
Route::get('/profil/kerjasama', function () {
    return "Halaman Kerjasama Segera Hadir";
})->name('profil.kerjasama');

Route::get('/profil/pimpinan-fakultas', [PublicStaffController::class, 'pimpinanFakultas'])->name('profil.pimpinan-fakultas');
Route::get('/profil/pimpinan-jurusan', [PublicStaffController::class, 'pimpinanJurusan'])->name('profil.pimpinan-jurusan');
Route::get('/profil/pimpinan-prodi', [PublicStaffController::class, 'pimpinanProdi'])->name('profil.pimpinan-prodi');
Route::get('/profil/pimpinan-laboratorium', [PublicStaffController::class, 'pimpinanLaboratorium'])->name('profil.pimpinan-laboratorium');
Route::get('/profil/dosen', [PublicStaffController::class, 'dosen'])->name('profil.dosen');
Route::get('/profil/tenaga-kependidikan', [PublicStaffController::class, 'tendik'])->name('profil.tenaga-kependidikan');

Route::get('/kegiatan-mahasiswa', [PublicKegiatanMahasiswaController::class, 'index'])->name('kegiatan.index');

// Route Agenda Publik
Route::get('/agenda-fakultas', [\App\Http\Controllers\Public\PublicAgendaFakultasController::class, 'index'])->name('agenda.index');

Route::get('/beasiswa', [PublicBeasiswaController::class, 'index'])->name('beasiswa.index');

Route::get('/informasi-pmb', function () {
    return Inertia::render('Public/PMB/Index');
})->name('pmb.index');


Route::get('/tracer-study', function () {
    return Inertia::render('Public/Alumni/TracerStudy');
})->name('tracer-study.index');

Route::get('/alumni', [PublicAlumniController::class, 'index'])->name('alumni.index');


// ==============================================================================
// 3. KELOMPOK ROUTE AUTHENTICATION
// ==============================================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
