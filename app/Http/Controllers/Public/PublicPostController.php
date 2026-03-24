<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicPostController extends Controller
{
    /**
     * Menampilkan halaman daftar berita publik.
     */
    public function index(Request $request)
    {
        // AMBIL SEMUA KATEGORI (Agar dropdown di Vue terisi)
        $categories = Post::where('status', 'Terbitkan')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        // 1. JIKA USER SEDANG MENCARI ATAU MEMFILTER KATEGORI
        if ($request->filled('search') || $request->filled('category')) {
            $query = Post::where('status', 'Terbitkan');

            // Filter berdasarkan kata kunci
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('excerpt', 'like', '%' . $request->search . '%');
                });
            }

            // Filter berdasarkan kategori dropdown
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            $searchResults = $query->latest()->paginate(12)->withQueryString();

            return Inertia::render('Public/Berita/Index', [
                'isSearching' => true,
                'searchResults' => $searchResults,
                'categories' => $categories, // <-- INI YANG SEBELUMNYA TERLEWAT
                'filters' => $request->only(['search', 'category']),
            ]);
        }

        // 2. JIKA HALAMAN AWAL (Tanpa filter/pencarian)
        
        // Headline (Berita Terpopuler)
        $headline = Post::where('status', 'Terbitkan')
            ->orderBy('views', 'desc')
            ->latest()
            ->first();

        // Berita Terbaru di bawah Headline
        $latestPosts = Post::where('status', 'Terbitkan')
            ->when($headline, function ($query) use ($headline) {
                return $query->where('id', '!=', $headline->id);
            })
            ->latest()
            ->take(6)
            ->get();

        // Berita Terkelompok per Kategori
        $groupedPosts = [];
        foreach ($categories as $category) {
            $posts = Post::where('status', 'Terbitkan')
                ->where('category', $category)
                ->when($headline, function ($query) use ($headline) {
                    return $query->where('id', '!=', $headline->id);
                })
                ->latest()
                ->take(3)
                ->get();

            if ($posts->isNotEmpty()) {
                $groupedPosts[] = [
                    'category_name' => $category,
                    'posts' => $posts
                ];
            }
        }

        return Inertia::render('Public/Berita/Index', [
            'isSearching' => false,
            'headline' => $headline,
            'latestPosts' => $latestPosts,
            'groupedPosts' => $groupedPosts,
            'categories' => $categories, // <-- INI YANG SEBELUMNYA TERLEWAT
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

        // Sidebar Berita Terbaru
        $recentPosts = Post::where('status', 'Terbitkan')
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(5)
            ->get();

        // Jika berita di database baru 1, munculkan berita itu sendiri agar tidak kosong
        if ($recentPosts->isEmpty()) {
            $recentPosts = Post::where('status', 'Terbitkan')->latest()->take(5)->get();
        }

        return Inertia::render('Public/Berita/Show', [
            'post' => $post,
            'recentPosts' => $recentPosts,
        ]);
    }
}