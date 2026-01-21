<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Achievement;
use App\Models\User;
use App\Models\Staff;
use App\Models\PpidDocument;
use App\Models\AlumniTracer;
use App\Models\SatisfactionSurvey;
use App\Models\IntegrityZone;
use App\Models\InternalService;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // === STATISTIK UTAMA (Cards) ===
        $stats = [
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('status', 'Terbitkan')->count(),
            'totalAchievements' => Achievement::count(),
            'totalStaff' => Staff::where('is_active', true)->count(),
            'totalDosen' => Staff::where('category', 'Dosen')->where('is_active', true)->count(),
            'totalTendik' => Staff::whereIn('category', ['Tendik', 'Tenaga Kependidikan'])->where('is_active', true)->count(),
            'totalUsers' => User::count(),
            'totalSurveys' => SatisfactionSurvey::count(),
            'avgRating' => round(SatisfactionSurvey::avg('rating') ?? 0, 1),
            'totalPpid' => PpidDocument::where('is_active', true)->count(),
            'totalAlumni' => AlumniTracer::where('is_active', true)->count(),
            'totalZonaIntegritas' => IntegrityZone::count(),
            'totalLayanan' => InternalService::where('is_active', true)->count(),
        ];

        // === DATA UNTUK CHARTS ===

        // 1. Prestasi per Program Studi
        $achievementsByProdi = Achievement::select('study_program', DB::raw('count(*) as total'))
            ->groupBy('study_program')
            ->orderByDesc('total')
            ->get()
            ->map(fn($item) => [
                'name' => $item->study_program ?? 'Lainnya',
                'total' => $item->total
            ]);

        // 2. Prestasi per Tingkat (Level)
        $achievementsByLevel = Achievement::select('level', DB::raw('count(*) as total'))
            ->groupBy('level')
            ->orderByDesc('total')
            ->get()
            ->map(fn($item) => [
                'name' => $item->level ?? 'Lainnya',
                'total' => $item->total
            ]);

        // 3. Prestasi per Kategori (Akademik/Non-Akademik)
        $achievementsByCategory = Achievement::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get()
            ->map(fn($item) => [
                'name' => $item->category ?? 'Lainnya',
                'total' => $item->total
            ]);

        // 4. Trend Prestasi per Tahun (5 tahun terakhir)
        $currentYear = now()->year;
        $achievementsTrend = Achievement::select('year', DB::raw('count(*) as total'))
            ->whereBetween('year', [$currentYear - 4, $currentYear])
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->map(fn($item) => [
                'year' => (string) $item->year,
                'total' => $item->total
            ]);

        // 5. Berita per Kategori
        $postsByCategory = Post::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get()
            ->map(fn($item) => [
                'name' => $item->category ?? 'Lainnya',
                'total' => $item->total
            ]);

        // 6. Berita per Status
        $postsByStatus = Post::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->map(fn($item) => [
                'name' => $item->status ?? 'Lainnya',
                'total' => $item->total
            ]);

        // 7. Distribusi Rating Kepuasan (1-5)
        $ratingDistribution = SatisfactionSurvey::select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->get()
            ->map(fn($item) => [
                'rating' => $item->rating,
                'total' => $item->total
            ]);

        // 8. Kepuasan per Tipe Responden
        $satisfactionByType = SatisfactionSurvey::select('respondent_type', DB::raw('AVG(rating) as avg_rating'), DB::raw('count(*) as total'))
            ->groupBy('respondent_type')
            ->get()
            ->map(fn($item) => [
                'name' => $item->respondent_type ?? 'Lainnya',
                'avgRating' => round($item->avg_rating, 1),
                'total' => $item->total
            ]);

        // 9. Staff per Kategori
        $staffByCategory = Staff::select('category', DB::raw('count(*) as total'))
            ->where('is_active', true)
            ->groupBy('category')
            ->orderByDesc('total')
            ->get()
            ->map(fn($item) => [
                'name' => $item->category ?? 'Lainnya',
                'total' => $item->total
            ]);

        // === DATA UNTUK RECENT ACTIVITY ===

        // Berita Terbaru
        $recentPosts = Post::select('id', 'title', 'slug', 'category', 'status', 'views', 'published_at', 'created_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Prestasi Terbaru
        $recentAchievements = Achievement::select('id', 'student_name', 'achievement_name', 'study_program', 'level', 'category', 'year', 'created_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Survey Terbaru
        $recentSurveys = SatisfactionSurvey::select('id', 'respondent_name', 'respondent_type', 'service_category', 'rating', 'feedback', 'created_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Top Viewed Posts
        $topViewedPosts = Post::select('id', 'title', 'slug', 'views', 'category')
            ->where('status', 'Terbitkan')
            ->orderByDesc('views')
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard/Index', [
            'stats' => $stats,
            'charts' => [
                'achievementsByProdi' => $achievementsByProdi,
                'achievementsByLevel' => $achievementsByLevel,
                'achievementsByCategory' => $achievementsByCategory,
                'achievementsTrend' => $achievementsTrend,
                'postsByCategory' => $postsByCategory,
                'postsByStatus' => $postsByStatus,
                'ratingDistribution' => $ratingDistribution,
                'satisfactionByType' => $satisfactionByType,
                'staffByCategory' => $staffByCategory,
            ],
            'recent' => [
                'posts' => $recentPosts,
                'achievements' => $recentAchievements,
                'surveys' => $recentSurveys,
                'topViewedPosts' => $topViewedPosts,
            ],
        ]);
    }
}
