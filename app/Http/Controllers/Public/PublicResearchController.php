<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Research;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicResearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Research::with('studyProgram');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('nama_dosen', 'like', "%{$request->search}%");
            });
        }
        
        if ($request->filled('year')) {
            $query->where('tahun', $request->year);
        }
        
        if ($request->filled('program')) {
            $query->where('study_program_id', $request->program);
        }

        $researchList = $query->orderBy('tahun', 'desc')->paginate(12)->withQueryString();

        return Inertia::render('Public/Research/Index', [
            'researchList' => $researchList,
            'stats' => ['total' => Research::count()],
            'filters' => $request->only(['search', 'year', 'program']),
            'years' => Research::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun'),
            'studyPrograms' => StudyProgram::select('id', 'name')->orderBy('name')->get(),
        ]);
    }
}