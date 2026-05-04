<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StudyProgram;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StaffController extends Controller
{
    private function checkDuplicatePosition($jabatan, $ignoreId = null)
    {
        if (!$jabatan) return false;

        $jabStr = strtolower($jabatan);
        $query = Staff::query();
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if (str_contains($jabStr, 'dekan') && !str_contains($jabStr, 'wakil')) {
            if ((clone $query)->where('structural_position', 'LIKE', '%dekan%')
                ->where('structural_position', 'NOT LIKE', '%wakil%')->exists()
            ) {
                return 'Jabatan Dekan (Pimpinan Utama) sudah terisi. Tidak bisa menduplikat posisi ini.';
            }
        }

        if (str_contains($jabStr, 'wakil dekan') && str_contains($jabStr, 'akademik')) {
            if ((clone $query)->where('structural_position', 'LIKE', '%wakil dekan%')
                ->where('structural_position', 'LIKE', '%akademik%')->exists()
            ) {
                return 'Jabatan Wakil Dekan Bidang Akademik sudah terisi oleh civitas lain.';
            }
        }

        if (str_contains($jabStr, 'wakil dekan') && (str_contains($jabStr, 'keuangan') || str_contains($jabStr, 'umum'))) {
            if ((clone $query)->where('structural_position', 'LIKE', '%wakil dekan%')
                ->where(function ($q) {
                    $q->where('structural_position', 'LIKE', '%keuangan%')
                        ->orWhere('structural_position', 'LIKE', '%umum%');
                })->exists()
            ) {
                return 'Jabatan Wakil Dekan Bidang Keuangan dan Umum sudah terisi.';
            }
        }

        if (str_contains($jabStr, 'kepala subbagian') && str_contains($jabStr, 'umum')) {
            if ((clone $query)->where('structural_position', 'LIKE', '%kepala subbagian%')
                ->where('structural_position', 'LIKE', '%umum%')->exists()
            ) {
                return 'Jabatan Kepala Subbagian Umum sudah terisi.';
            }
        }

        if (str_contains($jabStr, 'ketua jurusan')) {
            $jurusans = Department::pluck('name');
            foreach ($jurusans as $jurusan) {
                if (str_contains($jabStr, strtolower($jurusan))) {
                    if ((clone $query)->where('structural_position', 'LIKE', '%ketua jurusan%')
                        ->where('structural_position', 'LIKE', '%' . $jurusan . '%')->exists()
                    ) {
                        return 'Jabatan Ketua Jurusan ' . ucwords($jurusan) . ' sudah terisi.';
                    }
                }
            }
        }

        if (str_contains($jabStr, 'koordinator program studi')) {
            $prodis = StudyProgram::pluck('name');
            foreach ($prodis as $prodi) {
                if (str_contains($jabStr, strtolower($prodi))) {
                    if ((clone $query)->where('structural_position', 'LIKE', '%koordinator program studi%')
                        ->where('structural_position', 'LIKE', '%' . $prodi . '%')->exists()
                    ) {
                        return 'Jabatan Koordinator Program Studi ' . ucwords($prodi) . ' sudah terisi.';
                    }
                }
            }
        }

        if (str_contains($jabStr, 'kepala laboratorium')) {
            $labs = [
                'inovasi digital',
                'sistem cerdas',
                'komputasi dan data',
                'fisika dasar',
                'fisika lanjut'
            ];
            foreach ($labs as $lab) {
                if (str_contains($jabStr, $lab)) {
                    if ((clone $query)->where('structural_position', 'LIKE', '%kepala laboratorium%')
                        ->where('structural_position', 'LIKE', '%' . $lab . '%')->exists()
                    ) {
                        return 'Jabatan Kepala Laboratorium ' . ucwords($lab) . ' sudah terisi.';
                    }
                }
            }
        }

        return false;
    }

    public function index(Request $request)
    {
        $query = Staff::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('type') && $request->type !== 'Semua') {
            $query->where('type', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'Semua') {
            $isActive = $request->status === 'Aktif' ? true : false;
            $query->where('is_active', $isActive);
        }

        $staff = $query->orderBy('type', 'asc')->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/Staff/Index', [
            'staff' => $staff,
            'filters' => $request->only(['search', 'type', 'status']),
        ]);
    }

    public function create()
    {
        $studyPrograms = StudyProgram::orderBy('name', 'asc')->get();
        $departments = Department::orderBy('name', 'asc')->pluck('name');

        return Inertia::render('Admin/Staff/Create', [
            'studyPrograms' => $studyPrograms,
            'departments' => $departments
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|numeric|unique:staff,nip',
            'type' => 'required|in:Dosen,Tendik',
            'structural_position' => ['nullable', 'string', 'max:255', 'unique:staff,structural_position'],
            'functional_position' => 'nullable|string|max:255',
            'image_url' => 'nullable|url',
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
            'academic_profiles.*' => 'nullable|url',
        ], [
            'nip.numeric' => 'NIP/NIPH harus berupa angka.',
            'nip.unique' => 'NIP/NIPH ini sudah terdaftar pada civitas lain.',
            'structural_position.unique' => 'Jabatan Struktural ini sudah terdaftar pada civitas lain.',
            'academic_profiles.*.url' => 'Format link profil tidak valid.',
            'image_url.url' => 'Format link drive (URL) foto diri formal tidak valid.'
        ]);

        if ($request->filled('structural_position')) {
            $errorMsg = $this->checkDuplicatePosition($request->structural_position);
            if ($errorMsg) {
                throw ValidationException::withMessages(['structural_position' => $errorMsg]);
            }
        }

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
        $departments = Department::orderBy('name', 'asc')->pluck('name');

        return Inertia::render('Admin/Staff/Edit', [
            'staff' => $staff,
            'studyPrograms' => $studyPrograms,
            'departments' => $departments
        ]);
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|numeric|unique:staff,nip,' . $staff->id,
            'type' => 'required|in:Dosen,Tendik',
            'structural_position' => ['nullable', 'string', 'max:255', Rule::unique('staff')->ignore($staff->id)],
            'functional_position' => 'nullable|string|max:255',
            'image_url' => 'nullable|url',
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
            'academic_profiles.*' => 'nullable|url',
        ], [
            'nip.numeric' => 'NIP/NIPH harus berupa angka.',
            'nip.unique' => 'NIP/NIPH ini sudah terdaftar pada civitas lain.',
            'structural_position.unique' => 'Jabatan Struktural ini sudah terdaftar pada civitas lain.',
            'academic_profiles.*.url' => 'Format link profil tidak valid.',
            'image_url.url' => 'Format link drive (URL) foto diri formal tidak valid.'
        ]);

        if ($request->filled('structural_position')) {
            $errorMsg = $this->checkDuplicatePosition($request->structural_position, $staff->id);
            if ($errorMsg) {
                throw ValidationException::withMessages(['structural_position' => $errorMsg]);
            }
        }

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
