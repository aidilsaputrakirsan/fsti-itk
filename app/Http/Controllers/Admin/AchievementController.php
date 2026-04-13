<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::query();
        if ($request->filled('search')) {
            $query->where('student_name', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $achievements = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('Admin/Achievements/Index', [
            'achievements' => $achievements,
            'filters' => $request->only(['search', 'category', 'level']),
            'categories' => Achievement::select('category')->distinct()->pluck('category'),
            'levels' => Achievement::select('level')->distinct()->pluck('level'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Achievements/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_nim' => 'nullable|string',
            'study_program' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'year' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('achievements', 'public');
        }

        Achievement::create([
            'student_name' => $validated['student_name'],
            'student_nim' => $validated['student_nim'],
            'study_program' => $validated['study_program'],
            'title' => $validated['title'],
            'category' => $validated['category'],
            'level' => $validated['level'],
            'organizer' => $validated['organizer'],
            'year' => $validated['year'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.achievements.index')->with('success', 'Data Prestasi berhasil ditambahkan.');
    }

    public function edit(Achievement $achievement)
    {
        return Inertia::render('Admin/Achievements/Edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_nim' => 'nullable|string',
            'study_program' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'year' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $achievement->fill($validated);

        if ($request->hasFile('image')) {
            if ($achievement->image_path && Storage::disk('public')->exists($achievement->image_path)) {
                Storage::disk('public')->delete($achievement->image_path);
            }
            $achievement->image_path = $request->file('image')->store('achievements', 'public');
        }

        $achievement->save();

        return redirect()->route('admin.achievements.index')->with('success', 'Data Prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement)
    {
        if ($achievement->image_path && Storage::disk('public')->exists($achievement->image_path)) {
            Storage::disk('public')->delete($achievement->image_path);
        }

        $achievement->delete();
        return redirect()->route('admin.achievements.index')->with('success', 'Data Prestasi berhasil dihapus.');
    }
}