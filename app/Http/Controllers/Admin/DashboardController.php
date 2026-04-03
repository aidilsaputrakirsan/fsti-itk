<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Achievement;
use App\Models\User;
use App\Models\Staff;
use App\Models\SatisfactionSurvey;
use App\Models\ZiDocument;
use App\Models\InternalService;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPpid = \App\Models\DokumenPpid::count();
        $totalKategoriPpid = \App\Models\KategoriPpid::count();

        // === STATISTIK UTAMA (Cards) ===
        $stats = [
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('status', 'Terbitkan')->count(),
            'totalAchievements' => Achievement::count(),
            'total_dosen' => Staff::where('type', 'Dosen')->where('is_active', true)->count(),
            'total_tendik' => Staff::where('type', 'Tendik')->where('is_active', true)->count(),
            'total_staff' => Staff::where('is_active', true)->count(),
            'totalUsers' => User::count(),
            'totalSurveys' => SatisfactionSurvey::count(),
            'avgRating' => round(SatisfactionSurvey::avg('rating') ?? 0, 1),
            'totalPpid' => $totalPpid,
            'totalKategoriPpid' => $totalKategoriPpid,
            'totalZonaIntegritas' => ZiDocument::count(),
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
        $postsByCategory = Post::join('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
            ->select('post_categories.name as category_name', DB::raw('count(posts.id) as total'))
            ->groupBy('post_categories.id', 'post_categories.name')
            ->get()
            ->map(fn($item) => [
                'name' => $item->category_name,
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
        $staffByCategory = Staff::select('type as category', DB::raw('count(*) as total'))
            ->where('is_active', true)
            ->groupBy('type')
            ->orderBy('total', 'desc')
            ->get();

        // === DATA UNTUK RECENT ACTIVITY ===

        // Berita Terbaru 
        $recentPosts = Post::with('category:id,name')
            ->select('id', 'title', 'slug', 'post_category_id', 'status', 'views', 'published_at', 'created_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(fn($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'category' => $post->category->name ?? 'Lainnya',
                'status' => $post->status,
                'views' => $post->views,
                'published_at' => $post->published_at,
                'created_at' => $post->created_at,
            ]);

        // Prestasi Terbaru
        $recentAchievements = Achievement::select('id', 'student_name', 'title as achievement_name', 'study_program', 'level', 'category', 'year', 'created_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Survey Terbaru
        $recentSurveys = SatisfactionSurvey::select('id', 'respondent_name', 'respondent_type', 'service_category', 'rating', 'feedback', 'created_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Top Viewed Posts 
        $topViewedPosts = Post::with('category:id,name')
            ->select('id', 'title', 'slug', 'views', 'post_category_id')
            ->where('status', 'Terbitkan')
            ->orderByDesc('views')
            ->take(5)
            ->get()
            ->map(fn($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'views' => $post->views,
                'category' => $post->category->name ?? 'Lainnya',
            ]);

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
                'totalPpid' => $totalPpid,
                'totalKategoriPpid' => $totalKategoriPpid,
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
