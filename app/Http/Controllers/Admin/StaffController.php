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

        // Fitur Pencarian berdasarkan nama
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan Tipe (Dosen/Tendik) jika diperlukan
        if ($request->has('type') && $request->type !== 'Semua') {
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
        // Validasi disesuaikan dengan struktur baru
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'type' => 'required|in:Dosen,Tendik',
            'structural_position' => 'nullable|string|max:255',
            'functional_position' => 'nullable|string|max:255',
            'image_url' => 'nullable|string', // Menyimpan Link Google Drive
            'is_active' => 'boolean',

            // Validasi format JSON Array (Jika dimasukkan dari form Vue)
            'education_history' => 'nullable|array',
            'expertise' => 'nullable|array',
            'competency_certification' => 'nullable|array',
            'research_history' => 'nullable|array',
            'community_service_history' => 'nullable|array',
            'work_experience' => 'nullable|array',
            'awards' => 'nullable|array',
            'academic_profiles' => 'nullable|array',
        ]);

        // Default value untuk is_active jika tidak dicentang
        $validated['is_active'] = $request->boolean('is_active', true);

        Staff::create($validated);

        return redirect()->route('admin.staff.index')
            ->with('message', 'Data Civitas (Staff) berhasil ditambahkan.');
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

        $validated['is_active'] = $request->boolean('is_active', true);

        $staff->update($validated);

        return redirect()->route('admin.staff.index')
            ->with('message', 'Data Civitas (Staff) berhasil diperbarui.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('message', 'Data Civitas (Staff) berhasil dihapus.');
    }
}
