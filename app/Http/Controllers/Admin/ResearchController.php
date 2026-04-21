<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Research;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResearchController extends Controller
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

        if ($request->filled('program')) {
            $query->where('study_program_id', $request->program);
        }

        $researchList = $query->latest()->paginate(10)->withQueryString();
        $studyPrograms = StudyProgram::all(['id', 'name']);

        return Inertia::render('Admin/Research/Index', [
            'researchList' => $researchList,
            'filters' => $request->only(['search', 'program']),
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function create()
    {
        $studyPrograms = StudyProgram::all(['id', 'name']);
        
        return Inertia::render('Admin/Research/Create', [
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'judul' => 'required|string',
            'study_program_id' => 'required|exists:study_programs,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        Research::create($validated);

        return redirect()->route('admin.penelitian.index')->with('success', 'Data penelitian berhasil ditambahkan.');
    }

    public function edit(Research $research)
    {
        $studyPrograms = StudyProgram::all(['id', 'name']);
        
        return Inertia::render('Admin/Research/Edit', [
            'research' => $research,
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function update(Request $request, Research $research)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'judul' => 'required|string',
            'study_program_id' => 'required|exists:study_programs,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $research->update($validated);

        return redirect()->route('admin.penelitian.index')->with('success', 'Data penelitian berhasil diperbarui.');
    }

    public function destroy(Research $research)
    {
        $research->delete();
        
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}