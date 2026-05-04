<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicPostController extends Controller
{
    public function index(Request $request)
    {
        $categories = PostCategory::whereHas('posts', function ($q) {
            $q->where('status', 'Terbitkan');
        })->pluck('name');

        if ($request->filled('search') || $request->filled('category')) {
            $query = Post::select('posts.*', 'post_categories.name as category')
                ->leftJoin('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
                ->where('posts.status', 'Terbitkan');

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('posts.title', 'like', '%' . $request->search . '%')
                        ->orWhere('posts.excerpt', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->filled('category')) {
                $query->where('post_categories.name', $request->category);
            }

            $searchResults = $query->latest('posts.created_at')->paginate(12)->withQueryString();

            return Inertia::render('Public/Posts/Index', [
                'isSearching' => true,
                'searchResults' => $searchResults,
                'categories' => $categories,
                'filters' => $request->only(['search', 'category']),
            ]);
        }

        $headline = Post::select('posts.*', 'post_categories.name as category')
            ->leftJoin('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
            ->where('posts.status', 'Terbitkan')
            ->orderBy('posts.views', 'desc')
            ->latest('posts.created_at')
            ->first();

        $latestPosts = Post::select('posts.*', 'post_categories.name as category')
            ->leftJoin('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
            ->where('posts.status', 'Terbitkan')
            ->when($headline, function ($query) use ($headline) {
                return $query->where('posts.id', '!=', $headline->id);
            })
            ->latest('posts.created_at')
            ->take(6)
            ->get();

        $groupedPosts = [];
        foreach ($categories as $categoryName) {
            $posts = Post::select('posts.*', 'post_categories.name as category')
                ->leftJoin('post_categories', 'posts.post_category_id', '=', 'post_categories.id')
                ->where('posts.status', 'Terbitkan')
                ->where('post_categories.name', $categoryName)
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

        return Inertia::render('Public/Posts/Index', [
            'isSearching' => false,
            'headline' => $headline,
            'latestPosts' => $latestPosts,
            'groupedPosts' => $groupedPosts,
            'categories' => $categories,
            'filters' => ['search' => '', 'category' => ''],
        ]);
    }

    public function show(Post $post)
    {
        if ($post->status !== 'Terbitkan') {
            abort(404);
        }

        $post->increment('views');

        $post->load('category');
        $postData = $post->toArray();
        $postData['category'] = $post->category ? $post->category->name : 'Umum';

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

        return Inertia::render('Public/Posts/Show', [
            'post' => $postData,
            'recentPosts' => $recentPosts,
        ]);
    }
}
