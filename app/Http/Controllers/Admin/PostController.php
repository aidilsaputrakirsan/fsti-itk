<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Menampilkan halaman utama daftar berita dengan filter.
     */
    public function index(Request $request)
    {
        $query = Post::with('category');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && in_array($request->status, ['Terbitkan', 'Draft'])) {
            $query->where('status', $request->status);
        }

        $posts = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Posts/Index', [
            'posts' => $posts,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        $categories = PostCategory::all();

        return Inertia::render('Admin/Posts/Create', [
            'categories' => $categories
        ]);
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'content' => 'required|string',
            'post_category_id' => 'required|exists:post_categories,id',
            'tags' => 'nullable|string',
            'status' => 'required|in:Draft,Terbitkan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validatedData['image_path'] = $path;
        }

        $validatedData['slug'] = Str::slug($request->title, '-');
        $validatedData['published_at'] = ($request->status === 'Terbitkan') ? now() : null;

        $validatedData['excerpt'] = Str::limit(strip_tags(html_entity_decode($request->content)), 150);

        Post::create($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit berita.
     */
    public function edit(Post $post)
    {
        $categories = PostCategory::all();

        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    /**
     * Memperbarui berita di database.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->id . ',id',
            'content' => 'required|string',
            'post_category_id' => 'required|exists:post_categories,id',
            'tags' => 'nullable|string',
            'status' => 'required|in:Draft,Terbitkan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $path = $request->file('image')->store('posts', 'public');
            $validatedData['image_path'] = $path;
        }

        $validatedData['slug'] = Str::slug($request->title, '-');

        if ($request->status === 'Terbitkan' && is_null($post->published_at)) {
            $validatedData['published_at'] = now();
        } elseif ($request->status === 'Draft') {
            $validatedData['published_at'] = null;
        }

        // LOGIKA EXCERPT OTOMATIS
        $validatedData['excerpt'] = Str::limit(strip_tags(html_entity_decode($request->content)), 150);

        $post->update($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Menghapus berita dari database.
     */
    public function destroy(Post $post)
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus.');
    }
}
