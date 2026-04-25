<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class PublicAlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('program')) {
            $query->where('study_program', $request->program);
        }

        if ($request->filled('year')) {
            $query->where('graduation_year', $request->year);
        }

        $alumni = $query->orderBy('graduation_year', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(20)
            ->withQueryString();

        $officialProdis = StudyProgram::orderBy('name')->pluck('name')->toArray();
        $alumniProdis = Alumni::select('study_program')->distinct()->pluck('study_program')->toArray();
        $studyPrograms = collect(array_merge($officialProdis, $alumniProdis))->filter()->unique()->sort()->values();

        $years = Alumni::select('graduation_year')->distinct()->orderBy('graduation_year', 'desc')->pluck('graduation_year');

        $distribution = Alumni::select('study_program', DB::raw('count(*) as total'))
            ->groupBy('study_program')
            ->orderBy('total', 'desc')
            ->get();

        return Inertia::render('Public/Alumni/Index', [
            'alumni' => $alumni,
            'filters' => $request->only(['search', 'program', 'year']),
            'studyPrograms' => $studyPrograms,
            'years' => $years,
            'distribution' => $distribution
        ]);
    }
}
