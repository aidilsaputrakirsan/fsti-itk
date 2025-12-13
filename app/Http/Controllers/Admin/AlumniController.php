<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\AlumniTracer::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $tracers = $query->latest('year')->paginate(10)->withQueryString();

        return \Inertia\Inertia::render('Admin/Alumni/Index', [
            'tracers' => $tracers,
            'filters' => $request->only(['search', 'type']),
        ]);
    }

    public function create()
    {
        return \Inertia\Inertia::render('Admin/Alumni/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Survey Link,Report',
            'url' => 'nullable|url',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'year' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('alumni', 'public');
            $validated['file_path'] = $path;
        }

        \App\Models\AlumniTracer::create($validated);

        return redirect()->route('admin.alumni.index')->with('success', 'Data tracer berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $tracer = \App\Models\AlumniTracer::findOrFail($id);

        return \Inertia\Inertia::render('Admin/Alumni/Edit', [
            'tracer' => $tracer,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $tracer = \App\Models\AlumniTracer::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:Survey Link,Report',
            'url' => 'nullable|url',
            'file' =>  'nullable|file|mimes:pdf|max:10240',
            'year' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('file')) {
            if ($tracer->file_path) {
                \Storage::disk('public')->delete($tracer->file_path);
            }
            $path = $request->file('file')->store('alumni', 'public');
            $validated['file_path'] = $path;
        }

        $tracer->update($validated);

        return redirect()->route('admin.alumni.index')->with('success', 'Data tracer berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $tracer = \App\Models\AlumniTracer::findOrFail($id);

        if ($tracer->file_path) {
            \Storage::disk('public')->delete($tracer->file_path);
        }

        $tracer->delete();

        return redirect()->route('admin.alumni.index')->with('success', 'Data tracer berhasil dihapus!');
    }
}
