<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternalService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InternalServiceController extends Controller
{
    public function index()
    {
        // Menampilkan data diurutkan berdasarkan sort_order dari terkecil ke terbesar
        $services = InternalService::orderBy('sort_order', 'asc')->paginate(10)->through(fn($item) => [
            'id' => $item->id,
            'name' => $item->name,
            'link_url' => $item->link_url,
            'description' => $item->description,
            'sort_order' => $item->sort_order,
        ]);
        return Inertia::render('Admin/InternalServices/Index', ['services' => $services]);
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
            'description' => 'required|string', // FIX: Deskripsi sekarang WAJIB
            'sort_order' => 'required|integer|min:1',
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
            ]
        ]);
    }

    public function update(Request $request, InternalService $internalService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'link_url' => 'required|url',
            'description' => 'required|string', // FIX: Deskripsi sekarang WAJIB
            'sort_order' => 'required|integer|min:1',
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