<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
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
                        ->paginate(15)
                        ->withQueryString();

        $officialProdis = StudyProgram::orderBy('name')->pluck('name')->toArray();
        $alumniProdis = Alumni::select('study_program')->distinct()->pluck('study_program')->toArray();
        $studyPrograms = collect(array_merge($officialProdis, $alumniProdis))->filter()->unique()->sort()->values();

        $years = Alumni::select('graduation_year')->distinct()->orderBy('graduation_year', 'desc')->pluck('graduation_year');

        return Inertia::render('Admin/Alumni/Index', [
            'alumni' => $alumni,
            'filters' => $request->only(['search', 'program', 'year']),
            'studyPrograms' => $studyPrograms,
            'years' => $years
        ]);
    }

    public function create()
    {
        $studyPrograms = StudyProgram::orderBy('name')->pluck('name');
        return Inertia::render('Admin/Alumni/Create', compact('studyPrograms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|unique:alumnis,nim|max:20',
            'name' => 'required|string|max:255',
            'study_program' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        Alumni::create($validated);

        return redirect()->route('admin.alumni.index')->with('success', 'Data Alumni berhasil ditambahkan.');
    }

    public function edit(Alumni $alumnus)
    {
        $studyPrograms = StudyProgram::orderBy('name')->pluck('name');
        return Inertia::render('Admin/Alumni/Edit', [
            'alumni' => $alumnus,
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function update(Request $request, Alumni $alumnus)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:alumnis,nim,' . $alumnus->id,
            'name' => 'required|string|max:255',
            'study_program' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $alumnus->update($validated);

        return redirect()->route('admin.alumni.index')->with('success', 'Data Alumni berhasil diperbarui.');
    }

    public function destroy(Alumni $alumnus)
    {
        $alumnus->delete();

        return redirect()->route('admin.alumni.index')->with('success', 'Data Alumni berhasil dihapus.');
    }
}