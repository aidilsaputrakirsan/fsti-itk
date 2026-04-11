<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        return Inertia::render('Admin/Announcements/Index', [
            'announcements' => $query->latest()->paginate(15)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Announcements/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document' => 'nullable|mimes:pdf|max:5120',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $documentPath = $request->hasFile('document') ? $request->file('document')->store('pengumuman', 'public') : null;
        $posterPath = $request->hasFile('poster') ? $request->file('poster')->store('pengumuman/poster', 'public') : null;

        Announcement::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'document_path' => $documentPath,
            'poster_path' => $posterPath,
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function edit(Announcement $announcement)
    {
        return Inertia::render('Admin/Announcements/Edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document' => 'nullable|mimes:pdf|max:5120',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('document')) {
            if ($announcement->document_path) Storage::disk('public')->delete($announcement->document_path);
            $announcement->document_path = $request->file('document')->store('pengumuman', 'public');
        }

        if ($request->hasFile('poster')) {
            if ($announcement->poster_path) Storage::disk('public')->delete($announcement->poster_path);
            $announcement->poster_path = $request->file('poster')->store('pengumuman/poster', 'public');
        }

        $announcement->title = $validated['title'];
        $announcement->description = $validated['description'];
        $announcement->save();

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->document_path) Storage::disk('public')->delete($announcement->document_path);
        if ($announcement->poster_path) Storage::disk('public')->delete($announcement->poster_path);

        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman beserta dokumennya berhasil dihapus.');
    }
}
