<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penelitian;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PenelitianController extends Controller
{
    public function index(Request $request)
    {
        // Panggil relasi studyProgram agar nama prodi bisa ditampilkan di tabel
        $query = Penelitian::with('studyProgram');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('nama_dosen', 'like', "%{$request->search}%");
            });
        }

        if ($request->prodi) {
            $query->where('study_program_id', $request->prodi);
        }

        $penelitians = $query->latest()->paginate(10)->withQueryString();
        $prodis = StudyProgram::all(['id', 'name']);

        return Inertia::render('Admin/Penelitian/Index', [
            'penelitians' => $penelitians,
            'filters' => $request->only(['search', 'prodi']),
            'prodis' => $prodis
        ]);
    }

    public function create()
    {
        $prodis = StudyProgram::all(['id', 'name']);
        
        return Inertia::render('Admin/Penelitian/Create', [
            'prodis' => $prodis
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'judul' => 'required|string',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        Penelitian::create($validated);

        return redirect()->route('admin.penelitian.index')->with('success', 'Data penelitian berhasil ditambahkan.');
    }

    public function edit(Penelitian $penelitian)
    {
        $prodis = StudyProgram::all(['id', 'name']);
        
        return Inertia::render('Admin/Penelitian/Edit', [
            'penelitian' => $penelitian,
            'prodis' => $prodis
        ]);
    }

    public function update(Request $request, Penelitian $penelitian)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'judul' => 'required|string',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $penelitian->update($validated);

        return redirect()->route('admin.penelitian.index')->with('success', 'Data penelitian berhasil diperbarui.');
    }

    public function destroy(Penelitian $penelitian)
    {
        $penelitian->delete();
        
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}