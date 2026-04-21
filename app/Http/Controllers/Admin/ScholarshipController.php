<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('provider', 'like', '%' . $request->search . '%');
            });
        }

        $scholarships = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Scholarships/Index', [
            'scholarships' => $scholarships,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Scholarships/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'nullable|string|max:255',
            'description' => 'required|string',
            'link_url' => ['nullable', 'url', 'max:255', 'regex:/^https?:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}/'],
        ]);

        Scholarship::create($validated);

        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil ditambahkan.');
    }

    public function edit(Scholarship $scholarship)
    {
        return Inertia::render('Admin/Scholarships/Edit', [
            'scholarship' => $scholarship
        ]);
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'nullable|string|max:255',
            'description' => 'required|string',
            'link_url' => ['nullable', 'url', 'max:255', 'regex:/^https?:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}/'],
        ]);

        $scholarship->update($validated);

        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil diperbarui.');
    }

    public function destroy(Scholarship $scholarship)
    {
        $scholarship->delete();

        return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil dihapus.');
    }
}