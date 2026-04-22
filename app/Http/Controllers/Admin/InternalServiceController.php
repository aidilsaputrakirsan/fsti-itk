<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternalService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

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
            'link_url' => 'required|url|unique:internal_services,link_url|regex:/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/',
            'description' => 'required|string',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        InternalService::where('sort_order', '>=', (int) $validated['sort_order'])->increment('sort_order');

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
            'link_url' => [
                'required',
                'url',
                Rule::unique('internal_services')->ignore($internalService->id),
                'regex:/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/'
            ],
            'description' => 'required|string',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'Nama layanan wajib diisi.',
            'name.max' => 'Nama layanan maksimal 255 karakter.',
            'link_url.required' => 'Tautan URL wajib diisi.',
            'link_url.url' => 'Format tautan tidak valid.',
            'link_url.unique' => 'Tautan URL ini sudah digunakan oleh layanan lain.',
            'link_url.regex' => 'Format tautan tidak valid (harus mengandung nama domain lengkap).',
            'description.required' => 'Deskripsi layanan wajib diisi.',
            'sort_order.required' => 'Urutan tampil wajib diisi.',
            'sort_order.integer' => 'Urutan tampil harus berupa angka.',
            'sort_order.min' => 'Urutan tampil minimal adalah 1.',
        ]);

        $oldOrder = (int) $internalService->sort_order;
        $newOrder = (int) $validated['sort_order'];

        if ($oldOrder !== $newOrder) {
            if ($oldOrder === 0) {
                InternalService::where('sort_order', '>=', $newOrder)->increment('sort_order');
            } elseif ($oldOrder < $newOrder) {
                InternalService::whereBetween('sort_order', [$oldOrder + 1, $newOrder])->decrement('sort_order');
            } else {
                InternalService::whereBetween('sort_order', [$newOrder, $oldOrder - 1])->increment('sort_order');
            }
        }

        $internalService->update($validated);
        return redirect()->route('admin.internal-services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(InternalService $internalService)
    {
        $deletedOrder = $internalService->sort_order;
        $internalService->delete();

        InternalService::where('sort_order', '>', $deletedOrder)->decrement('sort_order');

        return redirect()->route('admin.internal-services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
