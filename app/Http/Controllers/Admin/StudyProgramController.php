<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudyProgramController extends Controller
{
    public function index()
    {
        $studyPrograms = StudyProgram::orderBy('degree')->orderBy('name')->get();
        return Inertia::render('Admin/StudyPrograms/Index', [
            'studyPrograms' => $studyPrograms
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/StudyPrograms/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'degree' => 'required|string|max:10',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'goals' => 'nullable|string',
            'graduate_profiles' => 'nullable|string',
            'accreditation_certificate_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'accreditation_pdf_link' => 'nullable|url',
            'accreditation_text' => 'nullable|string',
            'website_link' => 'nullable|url',
        ]);

        $data = $request->except(['accreditation_certificate_image', 'mission', 'graduate_profiles']);

        // Buat slug otomatis dari Jenjang + Nama (Contoh: S1 Matematika -> s1-matematika)
        $data['slug'] = Str::slug($request->degree . ' ' . $request->name);

        // Ubah teks baris baru (Enter) menjadi Array untuk JSON
        $data['mission'] = $request->mission ? array_values(array_filter(array_map('trim', explode("\n", $request->mission)))) : null;
        $data['graduate_profiles'] = $request->graduate_profiles ? array_values(array_filter(array_map('trim', explode("\n", $request->graduate_profiles)))) : null;

        // Proses Upload Gambar
        if ($request->hasFile('accreditation_certificate_image')) {
            $path = $request->file('accreditation_certificate_image')->store('prodi', 'public');
            $data['accreditation_certificate_image'] = '/storage/' . $path;
        }

        StudyProgram::create($data);

        return redirect()->route('admin.study-programs.index')->with('success', 'Program Studi berhasil ditambahkan!');
    }

    public function edit(StudyProgram $studyProgram)
    {
        return Inertia::render('Admin/StudyPrograms/Edit', [
            'studyProgram' => $studyProgram
        ]);
    }

    public function update(Request $request, StudyProgram $studyProgram)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'degree' => 'required|string|max:10',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'goals' => 'nullable|string',
            'graduate_profiles' => 'nullable|string',
            'accreditation_certificate_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'accreditation_pdf_link' => 'nullable|url',
            'accreditation_text' => 'nullable|string',
            'website_link' => 'nullable|url',
        ]);

        $data = $request->except(['accreditation_certificate_image', 'mission', 'graduate_profiles']);
        $data['slug'] = Str::slug($request->degree . ' ' . $request->name);

        // Ubah teks baris baru menjadi Array
        $data['mission'] = $request->mission ? array_values(array_filter(array_map('trim', explode("\n", $request->mission)))) : null;
        $data['graduate_profiles'] = $request->graduate_profiles ? array_values(array_filter(array_map('trim', explode("\n", $request->graduate_profiles)))) : null;

        // Proses Upload Gambar Baru & Hapus Gambar Lama
        if ($request->hasFile('accreditation_certificate_image')) {
            // Hapus file lama jika ada dan bukan gambar bawaan seeder
            if ($studyProgram->accreditation_certificate_image && str_starts_with($studyProgram->accreditation_certificate_image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $studyProgram->accreditation_certificate_image));
            }
            $path = $request->file('accreditation_certificate_image')->store('prodi', 'public');
            $data['accreditation_certificate_image'] = '/storage/' . $path;
        }

        $studyProgram->update($data);

        return redirect()->route('admin.study-programs.index')->with('success', 'Program Studi berhasil diperbarui!');
    }

    public function destroy(StudyProgram $studyProgram)
    {
        // Hapus gambar jika ada
        if ($studyProgram->accreditation_certificate_image && str_starts_with($studyProgram->accreditation_certificate_image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $studyProgram->accreditation_certificate_image));
        }

        $studyProgram->delete();

        return redirect()->route('admin.study-programs.index')->with('success', 'Program Studi berhasil dihapus!');
    }
}
