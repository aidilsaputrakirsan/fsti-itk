<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Pengabdian;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicPengabdianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengabdian::with('studyProgram');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('nama_dosen', 'like', "%{$request->search}%");
            });
        }
        
        if ($request->prodi) {
            $query->where('study_program_id', $request->prodi);
        }

        if ($request->year) {
            $query->where('tahun', $request->year);
        }

        $pengabdians = $query->latest()->paginate(10)->withQueryString();
        
        $years = Pengabdian::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $prodis = StudyProgram::all(['id', 'name']);

        return Inertia::render('Public/Pengabdian/Index', [
            'pengabdians' => $pengabdians,
            'filters' => $request->only(['search', 'prodi', 'year']),
            'years' => $years,
            'prodis' => $prodis,
            'stats' => [
                'total' => Pengabdian::count(),
            ]
        ]);
    }
}