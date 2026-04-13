<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PpidCategory;
use Inertia\Inertia;

class PpidCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PpidCategory::query();

        if ($request->filled('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis_informasi', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('urutan', 'asc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/PpidCategories/Index', [
            'categories' => $categories,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/PpidCategories/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_informasi' => 'required|string|max:255',
            'nama_kategori' => 'required|string|max:255',
            'urutan' => 'nullable|integer',
        ]);

        PpidCategory::create($request->all());

        return redirect()->route('admin.kategori-ppid.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $category = PpidCategory::findOrFail($id);
        
        return Inertia::render('Admin/PpidCategories/Edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis_informasi' => 'required|string|max:255',
            'nama_kategori' => 'required|string|max:255',
            'urutan' => 'nullable|integer',
        ]);

        $category = PpidCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.kategori-ppid.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        PpidCategory::findOrFail($id)->delete();
        
        return redirect()->route('admin.kategori-ppid.index')->with('success', 'Kategori berhasil dihapus!');
    }
}