<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanMahasiswa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KegiatanMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = KegiatanMahasiswa::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('organizer', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        $years = KegiatanMahasiswa::selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $kegiatan = $query->orderBy('start_date', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/Kegiatan/Index', [
            'kegiatan' => $kegiatan,
            'filters' => $request->only(['search', 'year']),
            'availableYears' => $years
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Kegiatan/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'organizer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        KegiatanMahasiswa::create($validated);

        return redirect()->route('admin.kegiatan-mahasiswa.index')->with('success', 'Kegiatan mahasiswa berhasil ditambahkan.');
    }

    public function edit(KegiatanMahasiswa $kegiatan_mahasiswa)
    {
        return Inertia::render('Admin/Kegiatan/Edit', [
            'kegiatan' => $kegiatan_mahasiswa
        ]);
    }

    public function update(Request $request, KegiatanMahasiswa $kegiatan_mahasiswa)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'organizer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $kegiatan_mahasiswa->update($validated);

        return redirect()->route('admin.kegiatan-mahasiswa.index')->with('success', 'Kegiatan mahasiswa berhasil diperbarui.');
    }

    public function destroy(KegiatanMahasiswa $kegiatan_mahasiswa)
    {
        $kegiatan_mahasiswa->delete();
        return redirect()->route('admin.kegiatan-mahasiswa.index')->with('success', 'Kegiatan mahasiswa berhasil dihapus.');
    }
}