<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('student_name', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%')
                  ->orWhere('student_nim', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('level') && $request->level !== 'Semua') {
            $query->where('level', $request->level);
        }
        
        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        if ($request->filled('year') && $request->year !== 'Semua') {
            $query->where('year', $request->year);
        }

        $achievements = $query->latest('year')->latest('created_at')->paginate(10)->withQueryString();
        $years = Achievement::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return Inertia::render('Admin/Achievements/Index', [
            'achievements' => $achievements,
            'filters' => $request->only(['search', 'level', 'category', 'year']),
            'availableYears' => $years
        ]);
    }

    public function create()
    {
        $studyPrograms = StudyProgram::orderBy('name', 'asc')->get();
        
        return Inertia::render('Admin/Achievements/Create', [
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string',
            'student_nim' => 'nullable|string',
            'study_program' => 'nullable|string',
            'title' => 'required|string|max:255',
            'category' => 'required|in:Akademik,Non-Akademik',
            'level' => 'required|in:Internasional,Nasional,Provinsi,Kota/Kabupaten,Universitas',
            'organizer' => 'nullable|string|max:255',
            'year' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'certificate' => 'nullable|mimes:pdf,jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('achievements/images', 'public');
        }

        if ($request->hasFile('certificate')) {
            $validated['certificate_path'] = $request->file('certificate')->store('achievements/certificates', 'public');
        }

        Achievement::create($validated);

        return redirect()->route('admin.achievements.index')->with('success', 'Data prestasi berhasil ditambahkan.');
    }

    public function edit(Achievement $achievement)
    {
        $studyPrograms = StudyProgram::orderBy('name', 'asc')->get();
        
        return Inertia::render('Admin/Achievements/Edit', [
            'achievement' => $achievement,
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function update(Request $request, Achievement $achievement)
    {
        $validated = $request->validate([
            'student_name' => 'required|string',
            'student_nim' => 'nullable|string',
            'study_program' => 'nullable|string',
            'title' => 'required|string|max:255',
            'category' => 'required|in:Akademik,Non-Akademik',
            'level' => 'required|in:Internasional,Nasional,Provinsi,Kota/Kabupaten,Universitas',
            'organizer' => 'nullable|string|max:255',
            'year' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'certificate' => 'nullable|mimes:pdf,jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($achievement->image_path) {
                Storage::disk('public')->delete($achievement->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('achievements/images', 'public');
        }

        if ($request->hasFile('certificate')) {
            if ($achievement->certificate_path) {
                Storage::disk('public')->delete($achievement->certificate_path);
            }
            $validated['certificate_path'] = $request->file('certificate')->store('achievements/certificates', 'public');
        }

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')->with('success', 'Data prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement)
    {
        if ($achievement->image_path) {
            Storage::disk('public')->delete($achievement->image_path);
        }
        if ($achievement->certificate_path) {
            Storage::disk('public')->delete($achievement->certificate_path);
        }
        
        $achievement->delete();

        return redirect()->route('admin.achievements.index')->with('success', 'Data prestasi berhasil dihapus.');
    }
}