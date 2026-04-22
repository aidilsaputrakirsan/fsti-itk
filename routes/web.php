<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ==============================================================================
// CONTROLLER ADMIN
// ==============================================================================
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AlumniController as AdminAlumniController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\CommunityServiceController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacultyProfileController;
use App\Http\Controllers\Admin\IntegrityZoneController;
use App\Http\Controllers\Admin\InternalServiceController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\PpidCategoryController;
use App\Http\Controllers\Admin\SatisfactionSurveyController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudyProgramController as AdminStudyProgramController;
use App\Http\Controllers\Admin\SurveyCategoryController;
use App\Http\Controllers\Admin\PpidDocumentController;
use App\Http\Controllers\Admin\ResearchController;
use App\Http\Controllers\Admin\ScholarshipController;
use App\Http\Controllers\Admin\StudentActivityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;

// ==============================================================================
// CONTROLLER PUBLIK
// ==============================================================================
use App\Http\Controllers\Public\PublicAchievementController;
use App\Http\Controllers\Public\PublicAlumniController;
use App\Http\Controllers\Public\PublicAnnouncementController;
use App\Http\Controllers\Public\PublicPartnerController;
use App\Http\Controllers\Public\PublicPostController;
use App\Http\Controllers\Public\PublicProfileController;
use App\Http\Controllers\Public\PublicStaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\PublicAgendaController;
use App\Http\Controllers\Public\PublicCommunityServiceController;
use App\Http\Controllers\Public\PublicIntegrityZoneController;
use App\Http\Controllers\Public\PublicPpidDocumentController;
use App\Http\Controllers\Public\PublicResearchController;
use App\Http\Controllers\Public\PublicSatisfactionSurveyController;
use App\Http\Controllers\Public\PublicScholarshipController;
use App\Http\Controllers\Public\PublicStudentActivityController;
use App\Http\Controllers\Public\PublicStudyProgramController;

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
    Route::get('/tentang-fakultas', [FacultyProfileController::class, 'edit'])->name('faculty-profiles.edit');
    Route::put('/tentang-fakultas', [FacultyProfileController::class, 'update'])->name('faculty-profiles.update');

    // MODUL KONTAK
    Route::get('/contacts', [AdminContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts', [AdminContactController::class, 'update'])->name('contacts.update');

    // MODUL STAF
    Route::resource('/staff', StaffController::class);

    // MODUL PROGRAM STUDI
    Route::resource('/study-programs', AdminStudyProgramController::class)->except(['show']);

    // MODUL JURUSAN
    Route::resource('/departments', DepartmentController::class)->only(['index', 'store', 'update', 'destroy']);

    // MODUL BERITA
    Route::resource('/posts', AdminPostController::class);

    // MODUL KATEGORI BERITA
    Route::resource('post-categories', PostCategoryController::class)->except(['show']);

    // MODUL PENGUMUMAN
    Route::resource('announcements', AdminAnnouncementController::class);

    // MODUL AGENDA FAKULTAS
    Route::resource('/agenda-fakultas', AgendaController::class);

    // MODUL PRESTASI
    Route::resource('/achievements', AchievementController::class);

    // MODUL KEGIATAN MAHASISWA
    Route::resource('kegiatan-mahasiswa', StudentActivityController::class)
        ->parameters(['kegiatan_mahasiswa' => 'studentActivity']);

    // MODUL PENELITIAN
    Route::resource('penelitian', ResearchController::class)
        ->parameters(['penelitian' => 'research'])
        ->except(['show']);

    // MODUL PENGABDIAN
    Route::resource('pengabdian', CommunityServiceController::class)
        ->parameters(['pengabdian' => 'communityService'])
        ->except(['show']);

    // MODUL LAYANAN 
    Route::resource('/internal-services', InternalServiceController::class);

    // MODUL PPID
    Route::resource('/ppid', PpidDocumentController::class);

    // MODUL KATEGORI PPID
    Route::resource('/kategori-ppid', PpidCategoryController::class);

    // MODUL BEASISWA
    Route::resource('beasiswa', ScholarshipController::class)->parameters(['beasiswa' => 'scholarship']);

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

    $allProdi = \App\Models\StudyProgram::all();
    $s1 = 0;
    $s2 = 0;

    foreach ($allProdi as $p) {
        $degree = strtoupper($p->degree ?? '');
        $name = strtolower($p->name);

        if ($degree === 'S2' || str_contains($name, 's2') || str_contains($name, 'magister')) {
            $s2++;
        } else {
            $s1++;
        }
    }

    $statistics = [
        'dosen' => \App\Models\Staff::where('type', 'Dosen')->where('is_active', true)->count(),
        'tendik' => \App\Models\Staff::where('type', 'Tendik')->where('is_active', true)->count(),
        'prodi_s1' => $s1,
        'prodi_s2' => $s2,
        'prodi_total' => $allProdi->count(),
        'kunjungan' => \App\Models\Visitor::count(),
        'jurusan' => \App\Models\Department::count(),
        'alumni' => \App\Models\Alumni::count(),
    ];

    $profile = \App\Models\FacultyProfile::first();
    $profileContent = $profile ? $profile->content : null;

    if ($profileContent && isset($profileContent['statistik']['data'])) {
        foreach ($profileContent['statistik']['data'] as &$stat) {
            $label = strtolower($stat['label']);
            if (str_contains($label, 'dosen')) $stat['angka'] = (string)$statistics['dosen'];
            if (str_contains($label, 'tendik') || str_contains($label, 'kependidikan')) $stat['angka'] = (string)$statistics['tendik'];
            if (str_contains($label, 's1')) $stat['angka'] = (string)$statistics['prodi_s1'];
            if (str_contains($label, 's2') || str_contains($label, 'magister')) $stat['angka'] = (string)$statistics['prodi_s2'];
            if ($label === 'program studi' || $label === 'prodi') $stat['angka'] = (string)$statistics['prodi_total'];
            if ($label === 'jurusan') $stat['angka'] = (string)$statistics['jurusan'];
            if (str_contains($label, 'alumni') || str_contains($label, 'lulusan')) $stat['angka'] = (string)$statistics['alumni'];
        }
    }

    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'latestPosts' => $latestPosts,
        'latestAchievements' => $latestAchievements,
        'profile' => $profileContent,
        'statistics' => $statistics,
    ]);
})->name('home');

// HALAMAN BERITA
Route::get('/berita', [PublicPostController::class, 'index'])->name('posts.index');
Route::get('/berita/{post:slug}', [PublicPostController::class, 'show'])->name('posts.show');

// HALAMAN PRESTASI
Route::get('/prestasi', [PublicAchievementController::class, 'index'])->name('achievements.index');

// HALAMAN TENTANG FAKULTAS
Route::get('/profil/tentang', [PublicProfileController::class, 'tentang'])->name('profiles.about');

// HALAMAN KONTAK
Route::get('/kontak', [PublicProfileController::class, 'kontak'])->name('profiles.contact');

// HALAMAN KERJASAMA
Route::get('/profil/kerjasama', function () {
    return "Halaman Kerjasama Segera Hadir";
})->name('profil.kerjasama');

// HALAMAN STRUKTUR ORGANISASI GABUNGAN
Route::get('/profil/struktur-organisasi', [PublicProfileController::class, 'strukturOrganisasi'])->name('profiles.structure');

// HALAMAN DOSEN
Route::get('/profil/dosen', [PublicStaffController::class, 'dosen'])->name('profiles.lecturers');

// HALAMAN TENAGA KEPENDIDIKAN
Route::get('/profil/tenaga-kependidikan', [PublicStaffController::class, 'tendik'])->name('profiles.support-staff');

// HALAMAN PROGRAM STUDI
Route::get('/prodi/{slug}', [PublicStudyProgramController::class, 'show'])->name('study-programs.show');

// HALAMAN KEGIATAN MAHASISWA
Route::get('/kegiatan-mahasiswa', [PublicStudentActivityController::class, 'index'])->name('student-activities.index');

// HALAMAN AGENDA FAKULTAS
Route::get('/agenda-fakultas', [PublicAgendaController::class, 'index'])->name('agendas.index');

// HALAMAN BEASISWA
Route::get('/beasiswa', [PublicScholarshipController::class, 'index'])->name('scholarships.index');

// HALAMAN PENGUMUMAN
Route::get('/pengumuman', [PublicAnnouncementController::class, 'index'])->name('announcements.index');

// HALAMAN MITRA
Route::get('/kerjasama', [PublicPartnerController::class, 'index'])->name('partners.index');

// HALAMAN PENELITIAN
Route::get('/penelitian', [PublicResearchController::class, 'index'])->name('research.index');

// HALAMAN PENGABDIAN
Route::get('/pengabdian', [PublicCommunityServiceController::class, 'index'])->name('community-services.index');

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
Route::get('/ppid', [PublicPpidDocumentController::class, 'index'])->name('ppid-documents.index');
Route::get('/ppid/informasi/{slug}', [PublicPpidDocumentController::class, 'show'])->name('ppid-documents.show');

// HALAMAN ZONA INTEGRITAS
Route::get('/zona-integritas', [PublicIntegrityZoneController::class, 'index'])->name('integrity-zones.index');

// HALAMAN SURVEI KEPUASAN
Route::get('/survei-kepuasan', [PublicSatisfactionSurveyController::class, 'index'])->name('satisfaction-surveys.index');
Route::post('/survei-kepuasan', [PublicSatisfactionSurveyController::class, 'store'])->name('satisfaction-surveys.store');

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
    return Inertia::render('Public/InternalServices/Index', ['services' => $services]);
})->name('internal-services.index');

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
