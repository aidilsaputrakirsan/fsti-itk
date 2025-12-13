<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InternalServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\InternalService::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $services = $query->orderBy('sort_order')->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return \Inertia\Inertia::render('Admin/InternalServices/Index', [
            'services' => $services,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function create()
    {
        return \Inertia\Inertia::render('Admin/InternalServices/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'required|url',
            'category' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        \App\Models\InternalService::create($validated);

        return redirect()->route('admin.internal-services.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $service = \App\Models\InternalService::findOrFail($id);

        return \Inertia\Inertia::render('Admin/InternalServices/Edit', [
            'service' => $service,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $service = \App\Models\InternalService::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'required|url',
            'category' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $service->update($validated);

        return redirect()->route('admin.internal-services.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $service = \App\Models\InternalService::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.internal-services.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
