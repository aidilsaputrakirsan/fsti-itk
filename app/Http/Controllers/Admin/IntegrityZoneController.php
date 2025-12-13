<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IntegrityZoneController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\IntegrityZone::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $items = $query->latest('published_at')->paginate(10)->withQueryString();

        return \Inertia\Inertia::render('Admin/IntegrityZones/Index', [
            'items' => $items,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function create()
    {
        return \Inertia\Inertia::render('Admin/IntegrityZones/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'image' => 'nullable|image|max:5120',
            'published_at' => 'required|date',
        ]);

        $validated['slug'] = \Str::slug($validated['title']);

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('integrity-zones/docs', 'public');
        }

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('integrity-zones/images', 'public');
        }

        \App\Models\IntegrityZone::create($validated);

        return redirect()->route('admin.integrity-zones.index')->with('success', 'Zona Integritas berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = \App\Models\IntegrityZone::findOrFail($id);

        return \Inertia\Inertia::render('Admin/IntegrityZones/Edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $item = \App\Models\IntegrityZone::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'image' => 'nullable|image|max:5120',
            'published_at' => 'required|date',
        ]);

        $validated['slug'] = \Str::slug($validated['title']);

        if ($request->hasFile('document')) {
            if ($item->document_path) {
                \Storage::disk('public')->delete($item->document_path);
            }
            $validated['document_path'] = $request->file('document')->store('integrity-zones/docs', 'public');
        }

        if ($request->hasFile('image')) {
            if ($item->image_path) {
                \Storage::disk('public')->delete($item->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('integrity-zones/images', 'public');
        }

        $item->update($validated);

        return redirect()->route('admin.integrity-zones.index')->with('success', 'Zona Integritas berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $item = \App\Models\IntegrityZone::findOrFail($id);

        if ($item->document_path) {
            \Storage::disk('public')->delete($item->document_path);
        }
        if ($item->image_path) {
            \Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return redirect()->route('admin.integrity-zones.index')->with('success', 'Zona Integritas berhasil dihapus!');
    }
}
