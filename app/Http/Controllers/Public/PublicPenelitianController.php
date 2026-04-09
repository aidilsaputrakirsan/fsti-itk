<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Penelitian;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicPenelitianController extends Controller
{
    public function index(Request $request)
    {
        $query = Penelitian::with('studyProgram');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('nama_dosen', 'like', "%{$request->search}%");
            });
        }
        if ($request->year) {
            $query->where('tahun', $request->year);
        }
        if ($request->prodi) {
            $query->where('study_program_id', $request->prodi);
        }

        $penelitians = $query->orderBy('tahun', 'desc')->paginate(12)->withQueryString();

        return Inertia::render('Public/Penelitian/Index', [
            'penelitians' => $penelitians,
            'stats' => ['total' => Penelitian::count()],
            'filters' => $request->only(['search', 'year', 'prodi']),
            'years' => Penelitian::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun'),
            'prodis' => StudyProgram::select('id', 'name')->orderBy('name')->get(),
        ]);
    }
}