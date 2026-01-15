<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class StaticPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = StaticPage::all();
        return Inertia::render('Admin/StaticPages/Index', [
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaticPage $staticPage)
    {
        return Inertia::render('Admin/StaticPages/Edit', [
            'page' => $staticPage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaticPage $staticPage)
    {
        // Validation logic depends on the key
        if ($staticPage->key === 'bagan-organisasi') {
            $request->validate([
                'image' => 'nullable|image|max:2048', // 2MB Max
            ]);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($staticPage->image_path) {
                    $oldPath = str_replace('/storage/', '', $staticPage->image_path);
                    Storage::disk('public')->delete($oldPath);
                }

                $path = $request->file('image')->store('profil', 'public');
                $staticPage->image_path = '/storage/' . $path;
            }
        } elseif ($staticPage->key === 'misi') {
            // Content is array of objects
            $data = $request->validate([
                'content' => 'required|array',
                'content.*.title' => 'required|string',
                'content.*.description' => 'required|string',
            ]);
            $staticPage->content = $data['content'];
        } else {
            // Standard Text Content (Visi)
            $data = $request->validate([
                'content' => 'required|string',
            ]);
            $staticPage->content = $data['content'];
        }

        $staticPage->save();

        return redirect()->route('admin.static-pages.index')->with('success', 'Halaman berhasil diperbarui!');
    }
}
