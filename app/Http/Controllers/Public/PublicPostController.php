<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicPostController extends Controller
{
    /**
     * Menampilkan halaman daftar berita publik.
     */
    public function index(Request $request)
    {
        // 1. Ambil nama-nama kategori dinamis yang punya berita aktif
        $categories = PostCategory::whereHas('posts', function ($q) {
            $q->where('status', 'Terbitkan');
        })->pluck('name');

        // 2. JIKA USER SEDANG MENCARI ATAU MEMFILTER KATEGORI
        if ($request->filled('search') || $request->filled('category')) {
            $query = Post::select('posts.*', 'post_categories.name as category')
                ->leftJoin('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
                ->where('posts.status', 'Terbitkan');

            // Filter berdasarkan kata kunci
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('posts.title', 'like', '%' . $request->search . '%')
                        ->orWhere('posts.excerpt', 'like', '%' . $request->search . '%');
                });
            }

            // Filter berdasarkan kategori dropdown
            if ($request->filled('category')) {
                $query->where('post_categories.name', $request->category);
            }

            $searchResults = $query->latest('posts.created_at')->paginate(12)->withQueryString();

            return Inertia::render('Public/Berita/Index', [
                'isSearching' => true,
                'searchResults' => $searchResults,
                'categories' => $categories,
                'filters' => $request->only(['search', 'category']),
            ]);
        }

        // 3. JIKA HALAMAN AWAL (Tanpa filter/pencarian)

        // Headline (Berita Terpopuler)
        $headline = Post::select('posts.*', 'post_categories.name as category')
            ->leftJoin('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
            ->where('posts.status', 'Terbitkan')
            ->orderBy('posts.views', 'desc')
            ->latest('posts.created_at')
            ->first();

        // Berita Terbaru di bawah Headline
        $latestPosts = Post::select('posts.*', 'post_categories.name as category')
            ->leftJoin('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
            ->where('posts.status', 'Terbitkan')
            ->when($headline, function ($query) use ($headline) {
                return $query->where('posts.id', '!=', $headline->id);
            })
            ->latest('posts.created_at')
            ->take(6)
            ->get();

        // Berita Terkelompok per Kategori
        $groupedPosts = [];
        foreach ($categories as $categoryName) {
            $posts = Post::select('posts.*', 'post_categories.name as category')
                ->leftJoin('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
                ->where('posts.status', 'Terbitkan')
                ->where('post_categories.name', $categoryName)
                ->when($headline, function ($query) use ($headline) {
                    return $query->where('posts.id', '!=', $headline->id);
                })
                ->latest('posts.created_at')
                ->take(3)
                ->get();

            if ($posts->isNotEmpty()) {
                $groupedPosts[] = [
                    'category_name' => $categoryName,
                    'posts' => $posts
                ];
            }
        }

        return Inertia::render('Public/Berita/Index', [
            'isSearching' => false,
            'headline' => $headline,
            'latestPosts' => $latestPosts,
            'groupedPosts' => $groupedPosts,
            'categories' => $categories,
            'filters' => ['search' => '', 'category' => ''],
        ]);
    }

    /**
     * Menampilkan halaman detail untuk satu berita.
     */
    public function show(Post $post)
    {
        if ($post->status !== 'Terbitkan') {
            abort(404);
        }

        $post->increment('views');

        // Render data post agar mengenali string kategori untuk Vue
        $post->load('category');
        $postData = $post->toArray();
        $postData['category'] = $post->category ? $post->category->name : 'Umum';

        // Sidebar Berita Terbaru
        $recentPosts = Post::with('category')
            ->where('status', 'Terbitkan')
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($p) {
                $arr = $p->toArray();
                $arr['category'] = $p->category ? $p->category->name : 'Umum';
                return $arr;
            });

        // Jika berita di database baru 1, munculkan berita itu sendiri agar sidebar tidak kosong
        if ($recentPosts->isEmpty()) {
            $recentPosts = Post::with('category')
                ->where('status', 'Terbitkan')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($p) {
                    $arr = $p->toArray();
                    $arr['category'] = $p->category ? $p->category->name : 'Umum';
                    return $arr;
                });
        }

        return Inertia::render('Public/Berita/Show', [
            'post' => $postData,
            'recentPosts' => $recentPosts,
        ]);
    }
}
