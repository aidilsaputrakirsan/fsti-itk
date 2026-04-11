<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ==============================================================================
// CONTROLLER ADMIN
// ==============================================================================
use App\Http\Controllers\Admin\AchievementsController;
use App\Http\Controllers\Admin\AgendaFakultasController as AdminAgendaFakultasController;
use App\Http\Controllers\Admin\AlumniController as AdminAlumniController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\BeasiswaController as AdminBeasiswaController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IntegrityZoneController;
use App\Http\Controllers\Admin\InternalServiceController;
use App\Http\Controllers\Admin\KategoriPpidController;
use App\Http\Controllers\Admin\KegiatanMahasiswaController as AdminKegiatanMahasiswaController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\PenelitianController as AdminPenelitianController;
use App\Http\Controllers\Admin\PengabdianController as AdminPengabdianController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\PpidController as AdminPpidController;
use App\Http\Controllers\Admin\SatisfactionSurveyController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudyProgramController as AdminStudyProgramController;
use App\Http\Controllers\Admin\SurveyCategoryController;
use App\Http\Controllers\Admin\TentangFakultasController;
use App\Http\Controllers\Admin\UserController;

// ==============================================================================
// CONTROLLER PUBLIK
// ==============================================================================
use App\Http\Controllers\Public\PublicAchievementController;
use App\Http\Controllers\Public\PublicAgendaFakultasController;
use App\Http\Controllers\Public\PublicAlumniController;
use App\Http\Controllers\Public\PublicAnnouncementController;
use App\Http\Controllers\Public\PublicBeasiswaController;
use App\Http\Controllers\Public\PublicKegiatanMahasiswaController;
use App\Http\Controllers\Public\PublicPartnerController;
use App\Http\Controllers\Public\PublicPenelitianController;
use App\Http\Controllers\Public\PublicPengabdianController;
use App\Http\Controllers\Public\PublicPostController;
use App\Http\Controllers\Public\PublicPpidController;
use App\Http\Controllers\Public\PublicProfileController;
use App\Http\Controllers\Public\PublicProgramStudiController;
use App\Http\Controllers\Public\PublicStaffController;
use App\Http\Controllers\Public\PublicSurveiController;
use App\Http\Controllers\Public\PublicZonaIntegritasController;
use App\Http\Controllers\ProfileController;

// ==============================================================================
// MODEL
// ==============================================================================
use App\Models\Achievement;
use App\Models\Post;

// ==============================================================================
// RUTE ADMIN
// ==============================================================================
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // MODUL PENGGUNA
    Route::resource('/users', UserController::class);

    // MODUL TENTANG FAKULTAS
    Route::get('/tentang-fakultas', [TentangFakultasController::class, 'edit'])->name('tentang.edit');
    Route::put('/tentang-fakultas', [TentangFakultasController::class, 'update'])->name('tentang.update');

    // MODUL KONTAK
    Route::get('/contacts', [AdminContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts', [AdminContactController::class, 'update'])->name('contacts.update');

    // MODUL STAF
    Route::resource('/staff', StaffController::class);

    // MODUL PROGRAM STUDI
    Route::resource('/study-programs', AdminStudyProgramController::class)->except(['show']);

    // MODUL BERITA
    Route::resource('/posts', AdminPostController::class);

    // MODUL KATEGORI BERITA
    Route::resource('post-categories', PostCategoryController::class)->except(['show']);

    // MODUL PENGUMUMAN
    Route::resource('announcements', AdminAnnouncementController::class);

    // MODUL AGENDA FAKULTAS
    Route::resource('/agenda-fakultas', AdminAgendaFakultasController::class);

    // MODUL PRESTASI
    Route::resource('/achievements', AchievementsController::class);

    // MODUL KEGIATAN MAHASISWA
    Route::resource('kegiatan-mahasiswa', AdminKegiatanMahasiswaController::class);

    // MODUL PENELITIAN
    Route::resource('penelitian', AdminPenelitianController::class)->except(['show']);

    // MODUL PENGABDIAN
    Route::resource('pengabdian', AdminPengabdianController::class)->except(['show']);

    // MODUL LAYANAN 
    Route::resource('/internal-services', InternalServiceController::class);

    // MODUL PPID
    Route::resource('/ppid', AdminPpidController::class);

    // MODUL KATEGORI PPID
    Route::resource('/kategori-ppid', KategoriPpidController::class);

    // MODUL BEASISWA
    Route::resource('beasiswa', AdminBeasiswaController::class);

    // MODUL ALUMNI
    Route::resource('/alumni', AdminAlumniController::class)->parameters(['alumni' => 'alumnus']);

    // MODUL MITRA
    Route::resource('partners', AdminPartnerController::class);

    // MODUL ZONA INTEGRITAS
    Route::prefix('zona-integritas')->name('zi.')->group(function () {
        Route::get('/profil', [IntegrityZoneController::class, 'profileEdit'])->name('profile.edit');
        Route::post('/profil', [IntegrityZoneController::class, 'profileUpdate'])->name('profile.update');
        Route::get('/dokumen', [IntegrityZoneController::class, 'documentIndex'])->name('document.index');
        Route::get('/dokumen/create', [IntegrityZoneController::class, 'documentCreate'])->name('document.create');
        Route::post('/dokumen', [IntegrityZoneController::class, 'documentStore'])->name('document.store');
        Route::get('/dokumen/{id}/edit', [IntegrityZoneController::class, 'documentEdit'])->name('document.edit');
        Route::post('/dokumen/{id}', [IntegrityZoneController::class, 'documentUpdate'])->name('document.update');
        Route::delete('/dokumen/{id}', [IntegrityZoneController::class, 'documentDestroy'])->name('document.destroy');
    });

    // MODUL SURVEI KEPUASAN
    Route::resource('/satisfaction-surveys', SatisfactionSurveyController::class);

    // MODUL KATEGORI SURVEI
    Route::get('/survey-categories', [SurveyCategoryController::class, 'index'])->name('survey-categories.index');
    Route::post('/survey-categories', [SurveyCategoryController::class, 'store'])->name('survey-categories.store');
    Route::put('/survey-categories/{surveyCategory}', [SurveyCategoryController::class, 'update'])->name('survey-categories.update');
    Route::delete('/survey-categories/{surveyCategory}', [SurveyCategoryController::class, 'destroy'])->name('survey-categories.destroy');
});

// ==============================================================================
// RUTE PUBLIK
// ==============================================================================

// HALAMAN BERANDA
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
        'kunjungan' => \App\Models\Visitor::count(),
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

// HALAMAN BERITA
Route::get('/berita', [PublicPostController::class, 'index'])->name('berita.index');
Route::get('/berita/{post:slug}', [PublicPostController::class, 'show'])->name('berita.show');

// HALAMAN PRESTASI
Route::get('/prestasi', [PublicAchievementController::class, 'index'])->name('prestasi.index');

// HALAMAN TENTANG FAKULTAS
Route::get('/profil/tentang', [PublicProfileController::class, 'tentang'])->name('profil.tentang');

// HALAMAN BAGAN ORGANISASI
Route::get('/profil/bagan-organisasi', [PublicProfileController::class, 'baganOrganisasi'])->name('bagan-organisasi');

// HALAMAN KONTAK
Route::get('/kontak', [PublicProfileController::class, 'kontak'])->name('kontak');

// HALAMAN KERJASAMA
Route::get('/profil/kerjasama', function () {
    return "Halaman Kerjasama Segera Hadir";
})->name('profil.kerjasama');

// HALAMAN PIMPINAN FAKULTAS
Route::get('/profil/pimpinan-fakultas', [PublicStaffController::class, 'pimpinanFakultas'])->name('profil.pimpinan-fakultas');

// HALAMAN PIMPINAN JURUSAN
Route::get('/profil/pimpinan-jurusan', [PublicStaffController::class, 'pimpinanJurusan'])->name('profil.pimpinan-jurusan');

// HALAMAN PIMPINAN PROGRAM STUDI
Route::get('/profil/pimpinan-prodi', [PublicStaffController::class, 'pimpinanProdi'])->name('profil.pimpinan-prodi');

// HALAMAN PIMPINAN LABORATORIUM
Route::get('/profil/pimpinan-laboratorium', [PublicStaffController::class, 'pimpinanLaboratorium'])->name('profil.pimpinan-laboratorium');

// HALAMAN DOSEN
Route::get('/profil/dosen', [PublicStaffController::class, 'dosen'])->name('profil.dosen');

// HALAMAN TENAGA KEPENDIDIKAN
Route::get('/profil/tenaga-kependidikan', [PublicStaffController::class, 'tendik'])->name('profil.tenaga-kependidikan');

// HALAMAN PROGRAM STUDI
Route::get('/prodi/{slug}', [PublicProgramStudiController::class, 'show'])->name('public.prodi.show');

// HALAMAN KEGIATAN MAHASISWA
Route::get('/kegiatan-mahasiswa', [PublicKegiatanMahasiswaController::class, 'index'])->name('kegiatan.index');

// HALAMAN AGENDA FAKULTAS
Route::get('/agenda-fakultas', [PublicAgendaFakultasController::class, 'index'])->name('agenda.index');

// HALAMAN BEASISWA
Route::get('/beasiswa', [PublicBeasiswaController::class, 'index'])->name('beasiswa.index');

// HALAMAN PENGUMUMAN
Route::get('/pengumuman', [PublicAnnouncementController::class, 'index'])->name('pengumuman.index');

// HALAMAN MITRA
Route::get('/kerjasama', [PublicPartnerController::class, 'index'])->name('kerjasama.index');

// HALAMAN PENELITIAN
Route::get('/penelitian', [PublicPenelitianController::class, 'index'])->name('penelitian.index');

// HALAMAN PENGABDIAN
Route::get('/pengabdian', [PublicPengabdianController::class, 'index'])->name('pengabdian.index');

// HALAMAN PENERIMAAN MAHASISWA BARU
Route::get('/informasi-pmb', function () {
    return Inertia::render('Public/PMB/Index');
})->name('pmb.index');

// HALAMAN TRACER STUDY
Route::get('/tracer-study', function () {
    return Inertia::render('Public/Alumni/TracerStudy');
})->name('tracer-study.index');

// HALAMAN ALUMNI
Route::get('/alumni', [PublicAlumniController::class, 'index'])->name('alumni.index');

// HALAMAN PPID
Route::get('/ppid', [PublicPpidController::class, 'index'])->name('public.ppid.index');
Route::get('/ppid/informasi/{slug}', [PublicPpidController::class, 'show'])->name('public.ppid.show');

// HALAMAN ZONA INTEGRITAS
Route::get('/zona-integritas', [PublicZonaIntegritasController::class, 'index'])->name('zona-integritas.index');

// HALAMAN SURVEI KEPUASAN
Route::get('/survei-kepuasan', [PublicSurveiController::class, 'index'])->name('survei.index');
Route::post('/survei-kepuasan', [PublicSurveiController::class, 'store'])->name('survei.store');

// HALAMAN LAYANAN
Route::get('/layanan-internal', function () {
    $services = \App\Models\InternalService::where('is_active', true)
        ->orderBy('sort_order', 'asc')
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'link_url' => $item->link_url,
            ];
        });
    return Inertia::render('Public/Layanan/Index', ['services' => $services]);
})->name('layanan.index');

// ==============================================================================
// RUTE AUTENTIKASI
// ==============================================================================

// PROFIL AKUN PENGGUNA
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// REDIRECT DASHBOARD
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// RUTE BREEZE
require __DIR__ . '/auth.php';
