<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BeasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Beasiswa::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('provider', 'like', '%' . $request->search . '%');
            });
        }

        $beasiswas = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Beasiswa/Index', [
            'beasiswas' => $beasiswas,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Beasiswa/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'nullable|string|max:255',
            'description' => 'required|string',
            'link_url' => 'nullable|url|max:255',
        ]);

        Beasiswa::create($validated);

        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil ditambahkan.');
    }

    public function edit(Beasiswa $beasiswa)
    {
        return Inertia::render('Admin/Beasiswa/Edit', [
            'beasiswa' => $beasiswa
        ]);
    }

    public function update(Request $request, Beasiswa $beasiswa)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'nullable|string|max:255',
            'description' => 'required|string',
            'link_url' => 'nullable|url|max:255',
        ]);

        $beasiswa->update($validated);

        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil diperbarui.');
    }

    public function destroy(Beasiswa $beasiswa)
    {
        $beasiswa->delete();

        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil dihapus.');
    }
}
