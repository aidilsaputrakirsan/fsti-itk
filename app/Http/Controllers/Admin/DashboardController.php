<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Achievement;
use App\Models\SatisfactionSurvey;
use App\Models\Visitor;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('status', 'Terbitkan')->count(),
            'totalAchievements' => Achievement::count(),
            'avgRating' => round(SatisfactionSurvey::avg('rating') ?? 0, 1),
            'totalVisitors' => Visitor::count(),
            'visitorsToday' => Visitor::whereDate('visit_date', Carbon::today())->count(),
            'visitorsMonth' => Visitor::whereMonth('visit_date', Carbon::now()->month)
                ->whereYear('visit_date', Carbon::now()->year)
                ->count(),
        ];

        $charts = [
            'achievementsTrend' => Achievement::selectRaw('year, count(*) as total')
                ->groupBy('year')
                ->orderBy('year')
                ->get(),

            'postsByCategory' => Post::join('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
                ->selectRaw('post_categories.name as name, count(*) as total')
                ->groupBy('post_categories.name')
                ->get(),
        ];

        $recent = [
            'topViewedPosts' => Post::with('category')->orderBy('views', 'desc')->limit(5)->get()->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'views' => $post->views,
                    'category' => $post->category ? $post->category->name : 'Tanpa Kategori',
                ];
            }),
            'surveys' => SatisfactionSurvey::latest()->limit(3)->get(),
            'achievements' => Achievement::latest()->limit(4)->get(),
        ];

        return Inertia::render('Admin/Dashboard/Index', [
            'stats' => $stats,
            'charts' => $charts,
            'recent' => $recent,
        ]);
    }
}
