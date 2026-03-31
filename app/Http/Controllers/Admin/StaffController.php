<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query();

        // Diperbarui: Bisa mencari berdasarkan Nama atau NIP
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('type') && $request->type !== 'Semua') {
            $query->where('type', $request->type);
        }

        // BARU: Filter berdasarkan Status Aktif/Nonaktif
        if ($request->filled('status') && $request->status !== 'Semua') {
            $isActive = $request->status === 'Aktif' ? true : false;
            $query->where('is_active', $isActive);
        }

        $staff = $query->orderBy('type', 'asc')->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/Staff/Index', [
            'staff' => $staff,
            'filters' => $request->only(['search', 'type', 'status']), // Status ditambahkan
        ]);
    }

    public function create()
    {
        $studyPrograms = StudyProgram::orderBy('name', 'asc')->get();
        return Inertia::render('Admin/Staff/Create', [
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'type' => 'required|in:Dosen,Tendik',
            'structural_position' => 'nullable|string|max:255',
            'functional_position' => 'nullable|string|max:255',
            'image_url' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'is_active' => 'required|boolean',
            'education_history' => 'nullable|array',
            'expertise' => 'nullable|array',
            'competency_certification' => 'nullable|array',
            'research_history' => 'nullable|array',
            'community_service_history' => 'nullable|array',
            'work_experience' => 'nullable|array',
            'awards' => 'nullable|array',
            'academic_profiles' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('staff', 'public');
            $validated['image_url'] = $path;
        }

        $validated['is_active'] = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);

        Staff::create($validated);
        return redirect()->route('admin.staff.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Staff $staff)
    {
        $studyPrograms = StudyProgram::orderBy('name', 'asc')->get();
        return Inertia::render('Admin/Staff/Edit', [
            'staff' => $staff,
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'type' => 'required|in:Dosen,Tendik',
            'structural_position' => 'nullable|string|max:255',
            'functional_position' => 'nullable|string|max:255',
            'image_url' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'required|boolean',
            'education_history' => 'nullable|array',
            'expertise' => 'nullable|array',
            'competency_certification' => 'nullable|array',
            'research_history' => 'nullable|array',
            'community_service_history' => 'nullable|array',
            'work_experience' => 'nullable|array',
            'awards' => 'nullable|array',
            'academic_profiles' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            if ($staff->image_url && !str_starts_with($staff->image_url, 'http')) {
                Storage::disk('public')->delete($staff->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('staff', 'public');

        } elseif ($request->filled('image_url')) {
            if ($staff->image_url && !str_starts_with($staff->image_url, 'http') && $staff->image_url !== $request->image_url) {
                Storage::disk('public')->delete($staff->image_url);
            }
            $validated['image_url'] = $request->image_url;

        } else {
            if ($staff->image_url && str_starts_with($staff->image_url, 'http')) {
                $validated['image_url'] = null;
            } else {
                unset($validated['image_url']);
            }
        }

        $validated['is_active'] = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);

        $staff->update($validated);
        return redirect()->route('admin.staff.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->image_url && !str_starts_with($staff->image_url, 'http')) {
            Storage::disk('public')->delete($staff->image_url);
        }
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Data berhasil dihapus.');
    }
}