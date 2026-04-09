<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengabdian;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PengabdianController extends Controller
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

        $pengabdians = $query->latest()->paginate(10)->withQueryString();
        $prodis = StudyProgram::all(['id', 'name']);

        return Inertia::render('Admin/Pengabdian/Index', [
            'pengabdians' => $pengabdians,
            'filters' => $request->only(['search', 'prodi']),
            'prodis' => $prodis
        ]);
    }

    public function create()
    {
        $prodis = StudyProgram::all(['id', 'name']);
        return Inertia::render('Admin/Pengabdian/Create', ['prodis' => $prodis]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'judul' => 'required|string',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        Pengabdian::create($validated);
        return redirect()->route('admin.pengabdian.index')->with('success', 'Data pengabdian berhasil ditambahkan.');
    }

    public function edit(Pengabdian $pengabdian)
    {
        $prodis = StudyProgram::all(['id', 'name']);
        return Inertia::render('Admin/Pengabdian/Edit', [
            'pengabdian' => $pengabdian,
            'prodis' => $prodis
        ]);
    }

    public function update(Request $request, Pengabdian $pengabdian)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'judul' => 'required|string',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $pengabdian->update($validated);
        return redirect()->route('admin.pengabdian.index')->with('success', 'Data pengabdian berhasil diperbarui.');
    }

    public function destroy(Pengabdian $pengabdian)
    {
        $pengabdian->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}