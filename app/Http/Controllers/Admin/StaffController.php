<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type') && $request->type !== 'Semua') {
            $query->where('type', $request->type);
        }

        $staff = $query->orderBy('type', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Staff/Index', [
            'staff' => $staff,
            'filters' => $request->only(['search', 'type']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Staff/Create');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
            'is_active' => 'boolean',

            'education_history' => 'nullable|array',
            'expertise' => 'nullable|array',
            'competency_certification' => 'nullable|array',
            'research_history' => 'nullable|array',
            'community_service_history' => 'nullable|array',
            'work_experience' => 'nullable|array',
            'awards' => 'nullable|array',
            'academic_profiles' => 'nullable|array',
        ]);

        // Prioritaskan file upload jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('staff', 'public');
            $validated['image_url'] = $path;
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        Staff::create($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data Civitas (Staff) berhasil ditambahkan.');
    }

    public function edit(Staff $staff)
    {
        return Inertia::render('Admin/Staff/Edit', [
            'staff' => $staff
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',

            'education_history' => 'nullable|array',
            'expertise' => 'nullable|array',
            'competency_certification' => 'nullable|array',
            'research_history' => 'nullable|array',
            'community_service_history' => 'nullable|array',
            'work_experience' => 'nullable|array',
            'awards' => 'nullable|array',
            'academic_profiles' => 'nullable|array',
        ]);

        // Cek jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus file lama jika bentuknya path lokal (bukan link eksternal/GDrive)
            if ($staff->image_url && !str_starts_with($staff->image_url, 'http')) {
                Storage::disk('public')->delete($staff->image_url);
            }
            $path = $request->file('image')->store('staff', 'public');
            $validated['image_url'] = $path;
        } elseif ($request->filled('image_url') && $request->image_url !== $staff->image_url) {
            // Jika user secara manual mengganti dengan link Gdrive baru, hapus juga file lokal lama jika ada
            if ($staff->image_url && !str_starts_with($staff->image_url, 'http')) {
                Storage::disk('public')->delete($staff->image_url);
            }
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $staff->update($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data Civitas (Staff) berhasil diperbarui.');
    }

    public function destroy(Staff $staff)
    {
        // Hapus foto lokal jika ada
        if ($staff->image_url && !str_starts_with($staff->image_url, 'http')) {
            Storage::disk('public')->delete($staff->image_url);
        }
        
        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data Civitas (Staff) berhasil dihapus.');
    }
}