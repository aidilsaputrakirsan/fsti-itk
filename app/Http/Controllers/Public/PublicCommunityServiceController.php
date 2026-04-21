<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CommunityService;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicCommunityServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = CommunityService::with('studyProgram');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('nama_dosen', 'like', "%{$request->search}%");
            });
        }
        
        if ($request->filled('program')) {
            $query->where('study_program_id', $request->program);
        }

        if ($request->filled('year')) {
            $query->where('tahun', $request->year);
        }

        $communityServices = $query->latest()->paginate(10)->withQueryString();
        
        $years = CommunityService::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $studyPrograms = StudyProgram::all(['id', 'name']);

        return Inertia::render('Public/CommunityServices/Index', [
            'communityServices' => $communityServices,
            'filters' => $request->only(['search', 'program', 'year']),
            'years' => $years,
            'studyPrograms' => $studyPrograms,
            'stats' => [
                'total' => CommunityService::count(),
            ]
        ]);
    }
}