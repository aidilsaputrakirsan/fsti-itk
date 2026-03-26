<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicAchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('student_name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $achievements = $query->orderByDesc('year')->latest()->paginate(12)->withQueryString()->through(fn ($item) => [
            'id' => $item->id,
            'title' => $item->title,
            'student_name' => $item->student_name,
            'study_program' => $item->study_program ?? '-',
            'level' => $item->level,
            'event_name' => $item->organizer ?? 'FSTI ITK',
            'date' => $item->year . '-01-01',
            'image_url' => $item->image_url,
        ]);

        $stats = [
            'total_all_time' => Achievement::count(),
            'international' => Achievement::where('level', 'Internasional')->count(),
            'national' => Achievement::where('level', 'Nasional')->count(),
            'academic' => Achievement::where('category', 'Akademik')->count(),
            'non_academic' => Achievement::where('category', 'Non-Akademik')->count(),
        ];

        return Inertia::render('Public/Prestasi/Index', [
            'achievements' => $achievements,
            'stats' => $stats,
            'filters' => $request->only(['search', 'year', 'level', 'category']),
            'years' => Achievement::select('year')->distinct()->orderByDesc('year')->pluck('year'),
            'levels' => ['Internasional', 'Nasional', 'Provinsi', 'Kota/Kabupaten', 'Universitas'],
            'categories' => ['Akademik', 'Non-Akademik'],
        ]);
    }
}