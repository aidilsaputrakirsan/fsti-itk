<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\FacultyProfile; 
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

        $achievements = $query->orderByDesc('year')->latest()->paginate(12)->withQueryString()->through(fn($item) => [
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

        $stats = [
            'total_all_time' => Achievement::count(),
            'international' => Achievement::where('level', 'Internasional')->count(),
            'national' => Achievement::where('level', 'Nasional')->count(),
            'academic' => Achievement::where('category', 'Akademik')->count(),
            'non_academic' => Achievement::where('category', 'Non-Akademik')->count(),
        ];

        $profile = FacultyProfile::first();
        $googleFormUrl = $profile?->content['prestasi_link'] ?? '#';

        return Inertia::render('Public/Achievements/Index', [
            'achievements' => $achievements,
            'stats' => $stats,
            'filters' => $request->only(['search', 'year', 'level', 'category']),
            'years' => Achievement::select('year')->distinct()->orderByDesc('year')->pluck('year'),
            'levels' => ['Internasional', 'Nasional', 'Provinsi', 'Kota/Kabupaten', 'Universitas'],
            'categories' => ['Akademik', 'Non-Akademik'],
            'googleFormUrl' => $googleFormUrl,
        ]);
    }
}