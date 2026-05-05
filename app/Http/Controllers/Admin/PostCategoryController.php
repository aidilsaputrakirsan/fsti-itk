<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PostCategory::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/PostCategories/Index', [
            'categories' => $categories,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/PostCategories/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_categories,name',
        ]);

        $validated['slug'] = Str::slug($request->name);
        PostCategory::create($validated);

        return redirect()->route('admin.post-categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(PostCategory $postCategory)
    {
        return Inertia::render('Admin/PostCategories/Edit', [
            'category' => $postCategory
        ]);
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_categories,name,' . $postCategory->id,
        ]);

        $validated['slug'] = Str::slug($request->name);
        $postCategory->update($validated);

        return redirect()->route('admin.post-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(PostCategory $postCategory)
    {
        if ($postCategory->posts()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena sedang digunakan oleh berita.');
        }

        $postCategory->delete();
        return redirect()->route('admin.post-categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
