<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityService;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommunityServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = CommunityService::with('studyProgram');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                    ->orWhere('nama_dosen', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('program')) {
            $query->where('study_program_id', $request->program);
        }

        $communityServices = $query->latest()->paginate(10)->withQueryString();
        $studyPrograms = StudyProgram::all(['id', 'name']);

        return Inertia::render('Admin/CommunityServices/Index', [
            'communityServices' => $communityServices,
            'filters' => $request->only(['search', 'program']),
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function create()
    {
        $studyPrograms = StudyProgram::all(['id', 'name']);
        
        return Inertia::render('Admin/CommunityServices/Create', [
            'studyPrograms' => $studyPrograms
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

        CommunityService::create($validated);
        
        return redirect()->route('admin.pengabdian.index')->with('success', 'Data pengabdian berhasil ditambahkan.');
    }

    public function edit(CommunityService $communityService)
    {
        $studyPrograms = StudyProgram::all(['id', 'name']);
        
        return Inertia::render('Admin/CommunityServices/Edit', [
            'communityService' => $communityService,
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function update(Request $request, CommunityService $communityService)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'judul' => 'required|string',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $communityService->update($validated);
        
        return redirect()->route('admin.pengabdian.index')->with('success', 'Data pengabdian berhasil diperbarui.');
    }

    public function destroy(CommunityService $communityService)
    {
        $communityService->delete();
        
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}