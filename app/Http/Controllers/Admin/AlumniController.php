<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();

        // Fitur Pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        // Fitur Filter Prodi & Tahun
        if ($request->filled('prodi')) {
            $query->where('study_program', $request->prodi);
        }
        if ($request->filled('year')) {
            $query->where('graduation_year', $request->year);
        }

        $alumnis = $query->orderBy('graduation_year', 'desc')
                         ->orderBy('name', 'asc')
                         ->paginate(15)
                         ->withQueryString();

        // Data untuk Dropdown Filter di Admin
        $prodis = Alumni::select('study_program')->distinct()->orderBy('study_program')->pluck('study_program');
        $years = Alumni::select('graduation_year')->distinct()->orderBy('graduation_year', 'desc')->pluck('graduation_year');

        return Inertia::render('Admin/Alumni/Index', [
            'alumnis' => $alumnis,
            'filters' => $request->only(['search', 'prodi', 'year']),
            'prodis' => $prodis,
            'years' => $years
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Alumni/Create');
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
        return Inertia::render('Admin/Alumni/Edit', [
            'alumni' => $alumnus
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