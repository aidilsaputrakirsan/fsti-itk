<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PpidCategory;
use App\Models\PpidDocument;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PpidCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PpidCategory::query();

        if ($request->filled('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis_informasi', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('jenis_informasi', 'asc')
                            ->orderBy('urutan', 'asc')
                            ->paginate(10)->withQueryString();

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
        $validated = $request->validate([
            'jenis_informasi' => 'required|string|max:255',
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ppid_categories')->where(function ($query) use ($request) {
                    return $query->where('jenis_informasi', $request->jenis_informasi);
                }),
            ],
            'urutan' => 'nullable|integer|min:1', 
        ], [
            'nama_kategori.unique' => 'Kategori ini sudah ada di dalam Jenis Informasi tersebut.',
            'urutan.min' => 'Urutan harus dimulai dari angka 1.',
        ]);

        $jenis = $request->jenis_informasi;

        if ($request->filled('urutan')) {
            $urutanBaru = $request->urutan;
            PpidCategory::where('jenis_informasi', $jenis)
                        ->where('urutan', '>=', $urutanBaru)
                        ->increment('urutan');
        } else {
            $max = PpidCategory::where('jenis_informasi', $jenis)->max('urutan');
            $validated['urutan'] = $max ? $max + 1 : 1;
        }

        $validated['slug'] = Str::slug($request->nama_kategori, '-');

        PpidCategory::create($validated);

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
        $category = PpidCategory::findOrFail($id);

        $validated = $request->validate([
            'jenis_informasi' => 'required|string|max:255',
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ppid_categories')->where(function ($query) use ($request) {
                    return $query->where('jenis_informasi', $request->jenis_informasi);
                })->ignore($category->id),
            ],
            'urutan' => 'nullable|integer|min:1',
        ], [
            'nama_kategori.unique' => 'Kategori ini sudah ada di dalam Jenis Informasi tersebut.',
            'urutan.min' => 'Urutan harus dimulai dari angka 1.',
        ]);

        $oldUrutan = $category->urutan;
        $newUrutan = $request->filled('urutan') ? $request->urutan : null;
        $oldJenis = $category->jenis_informasi;
        $newJenis = $request->jenis_informasi;

        if ($newUrutan === null) {
            $max = PpidCategory::where('jenis_informasi', $newJenis)->max('urutan');
            $newUrutan = $max ? $max + 1 : 1;
            $validated['urutan'] = $newUrutan;
        }

        if ($oldJenis === $newJenis) {
            if ($oldUrutan != $newUrutan) {
                if ($newUrutan < $oldUrutan) {
                    PpidCategory::where('jenis_informasi', $newJenis)
                                ->where('id', '!=', $category->id)
                                ->whereBetween('urutan', [$newUrutan, $oldUrutan - 1])
                                ->increment('urutan');
                } elseif ($newUrutan > $oldUrutan) {
                    PpidCategory::where('jenis_informasi', $newJenis)
                                ->where('id', '!=', $category->id)
                                ->whereBetween('urutan', [$oldUrutan + 1, $newUrutan])
                                ->decrement('urutan');
                }
            }
        } else {
            PpidCategory::where('jenis_informasi', $oldJenis)
                        ->where('urutan', '>', $oldUrutan)
                        ->decrement('urutan');

            PpidCategory::where('jenis_informasi', $newJenis)
                        ->where('urutan', '>=', $newUrutan)
                        ->increment('urutan');
        }

        $validated['slug'] = Str::slug($request->nama_kategori, '-');
        $category->update($validated);

        return redirect()->route('admin.kategori-ppid.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $category = PpidCategory::findOrFail($id);

        $isUsed = PpidDocument::where('ppid_category_id', $id)->exists();

        if ($isUsed) {
            return redirect()->route('admin.kategori-ppid.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh dokumen PPID.');
        }

        $oldUrutan = $category->urutan;
        $jenis = $category->jenis_informasi;

        $category->delete();

        PpidCategory::where('jenis_informasi', $jenis)
                    ->where('urutan', '>', $oldUrutan)
                    ->decrement('urutan');
        
        return redirect()->route('admin.kategori-ppid.index')->with('success', 'Kategori berhasil dihapus!');
    }
}