<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PpidController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\PpidDocument::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        return \Inertia\Inertia::render('Admin/Ppid/Index', [
            'documents' => $documents,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function create()
    {
        return \Inertia\Inertia::render('Admin/Ppid/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $validated['slug'] = \Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('ppid', 'public');
            $validated['file_path'] = $path;
        }

        \App\Models\PpidDocument::create($validated);

        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $document = \App\Models\PpidDocument::findOrFail($id);

        return \Inertia\Inertia::render('Admin/Ppid/Edit', [
            'document' => $document,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $document = \App\Models\PpidDocument::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $validated['slug'] = \Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active'); // Handle checkbox properly

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                \Storage::disk('public')->delete($document->file_path);
            }
            $path = $request->file('file')->store('ppid', 'public');
            $validated['file_path'] = $path;
        }

        $document->update($validated);

        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $document = \App\Models\PpidDocument::findOrFail($id);

        if ($document->file_path) {
            \Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil dihapus!');
    }
}
