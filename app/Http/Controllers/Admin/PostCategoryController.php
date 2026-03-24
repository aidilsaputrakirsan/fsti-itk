<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::latest()->paginate(10);
        return Inertia::render('Admin/PostCategories/Index', [
            'categories' => $categories
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
        // Cegah penghapusan jika kategori sedang dipakai oleh berita
        if ($postCategory->posts()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena sedang digunakan oleh berita.');
        }

        $postCategory->delete();
        return redirect()->route('admin.post-categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}