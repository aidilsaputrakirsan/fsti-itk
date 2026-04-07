<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternalService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InternalServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = InternalService::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $services = $query->orderBy('sort_order', 'asc')->paginate(10)->through(fn($item) => [
            'id' => $item->id,
            'name' => $item->name,
            'link_url' => $item->link_url,
            'description' => $item->description,
            'sort_order' => $item->sort_order,
            'is_active' => $item->is_active,
        ])->withQueryString();

        return Inertia::render('Admin/InternalServices/Index', [
            'services' => $services,
            'filters' => $request->only(['search', 'status'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/InternalServices/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'link_url' => 'required|url',
            'description' => 'required|string',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);
        
        InternalService::create($validated);
        return redirect()->route('admin.internal-services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(InternalService $internalService)
    {
        return Inertia::render('Admin/InternalServices/Edit', [
            'service' => [
                'id' => $internalService->id,
                'name' => $internalService->name,
                'link_url' => $internalService->link_url,
                'description' => $internalService->description,
                'sort_order' => $internalService->sort_order,
                'is_active' => $internalService->is_active,
            ]
        ]);
    }

    public function update(Request $request, InternalService $internalService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'link_url' => 'required|url',
            'description' => 'required|string',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);
        
        $internalService->update($validated);
        return redirect()->route('admin.internal-services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(InternalService $internalService)
    {
        $internalService->delete();
        return redirect()->route('admin.internal-services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}