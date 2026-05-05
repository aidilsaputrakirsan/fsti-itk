<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniTestimonial;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AlumniTestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = AlumniTestimonial::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('study_program', 'like', '%' . $request->search . '%');
        }

        $testimonials = $query->latest()->paginate(10)->withQueryString()->through(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'study_program' => $item->study_program,
                'is_active' => $item->is_active,
                'photo_url' => $item->photo ? asset('storage/' . $item->photo) : null,
            ];
        });

        return Inertia::render('Admin/AlumniTestimonials/Index', [
            'testimonials' => $testimonials,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        $studyPrograms = StudyProgram::orderBy('id', 'asc')->pluck('name')->toArray();

        return Inertia::render('Admin/AlumniTestimonials/Create', [
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'job' => 'nullable|string|max:255',
            'study_program' => 'required|string|max:255',
            'graduation_year' => 'required|string|max:4',
            'message' => 'required|string',
            'is_active' => 'boolean',
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'study_program.required' => 'Program studi wajib dipilih.',
            'graduation_year.required' => 'Tahun kelulusan wajib diisi.',
            'message.required' => 'Pesan / Kesan wajib diisi.',
            'photo.required' => 'Foto profil wajib diunggah.',
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus berupa JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('alumni_testimonials', 'public');
        }

        AlumniTestimonial::create($validated);
        return redirect()->route('admin.alumni-testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(AlumniTestimonial $alumniTestimonial)
    {
        $studyPrograms = StudyProgram::orderBy('id', 'asc')->pluck('name')->toArray();

        return Inertia::render('Admin/AlumniTestimonials/Edit', [
            'testimonial' => $alumniTestimonial,
            'photo_url' => $alumniTestimonial->photo ? asset('storage/' . $alumniTestimonial->photo) : null,
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function update(Request $request, AlumniTestimonial $alumniTestimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'job' => 'nullable|string|max:255',
            'study_program' => 'required|string|max:255',
            'graduation_year' => 'required|string|max:4',
            'message' => 'required|string',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'study_program.required' => 'Program studi wajib dipilih.',
            'graduation_year.required' => 'Tahun kelulusan wajib diisi.',
            'message.required' => 'Pesan / Kesan wajib diisi.',
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus berupa JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('photo')) {
            if ($alumniTestimonial->photo && !str_starts_with($alumniTestimonial->photo, 'images/')) {
                Storage::disk('public')->delete($alumniTestimonial->photo);
            }
            $validated['photo'] = $request->file('photo')->store('alumni_testimonials', 'public');
        } else {
            unset($validated['photo']);
        }

        $alumniTestimonial->update($validated);
        return redirect()->route('admin.alumni-testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(AlumniTestimonial $alumniTestimonial)
    {
        if ($alumniTestimonial->photo && !str_starts_with($alumniTestimonial->photo, 'images/')) {
            Storage::disk('public')->delete($alumniTestimonial->photo);
        }
        $alumniTestimonial->delete();
        return redirect()->route('admin.alumni-testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
