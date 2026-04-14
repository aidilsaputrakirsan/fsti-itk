<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            'name' => 'required|string|max:255|unique:study_programs,name',
            'department' => 'required|string|max:255',
            'degree' => 'required|string|max:10',
            'description' => 'required|string',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'goals' => 'required|string',
            'graduate_profiles' => 'required|string',
            'accreditation_text' => 'required|string',
            'accreditation_pdf_link' => 'required|url',
            'website_link' => 'required|url',
            'accreditation_certificate_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.unique' => 'Program Studi dengan nama ini sudah terdaftar.',
            'accreditation_pdf_link.url' => 'Tautan PDF harus berupa URL yang valid.',
            'website_link.url' => 'Tautan website harus berupa URL yang valid.',
        ]);

        $data = $request->except(['accreditation_certificate_image', 'mission', 'graduate_profiles']);

        $data['slug'] = Str::slug($request->degree . ' ' . $request->name);

        $data['mission'] = $request->mission ? array_values(array_filter(array_map('trim', explode("\n", $request->mission)))) : null;
        $data['graduate_profiles'] = $request->graduate_profiles ? array_values(array_filter(array_map('trim', explode("\n", $request->graduate_profiles)))) : null;

        if ($request->hasFile('accreditation_certificate_image')) {
            $path = $request->file('accreditation_certificate_image')->store('study_programs', 'public');
            $data['accreditation_certificate_image'] = $path;
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
            'name' => ['required', 'string', 'max:255', Rule::unique('study_programs')->ignore($studyProgram->id)],
            'department' => 'required|string|max:255',
            'degree' => 'required|string|max:10',
            'description' => 'required|string',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'goals' => 'required|string',
            'graduate_profiles' => 'required|string',
            'accreditation_text' => 'required|string',
            'accreditation_pdf_link' => 'required|url',
            'website_link' => 'required|url',
            'accreditation_certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.unique' => 'Program Studi dengan nama ini sudah terdaftar.',
            'accreditation_pdf_link.url' => 'Tautan PDF harus berupa URL yang valid.',
            'website_link.url' => 'Tautan website harus berupa URL yang valid.',
        ]);

        $data = $request->except(['accreditation_certificate_image', 'mission', 'graduate_profiles']);
        $data['slug'] = Str::slug($request->degree . ' ' . $request->name);

        $data['mission'] = $request->mission ? array_values(array_filter(array_map('trim', explode("\n", $request->mission)))) : null;
        $data['graduate_profiles'] = $request->graduate_profiles ? array_values(array_filter(array_map('trim', explode("\n", $request->graduate_profiles)))) : null;

        if ($request->hasFile('accreditation_certificate_image')) {
            if ($studyProgram->accreditation_certificate_image) {
                Storage::disk('public')->delete($studyProgram->accreditation_certificate_image);
            }
            $path = $request->file('accreditation_certificate_image')->store('study_programs', 'public');
            $data['accreditation_certificate_image'] = $path;
        }

        $studyProgram->update($data);

        return redirect()->route('admin.study-programs.index')->with('success', 'Program Studi berhasil diperbarui!');
    }

    public function destroy(StudyProgram $studyProgram)
    {
        if ($studyProgram->accreditation_certificate_image) {
            Storage::disk('public')->delete($studyProgram->accreditation_certificate_image);
        }

        $studyProgram->delete();

        return redirect()->route('admin.study-programs.index')->with('success', 'Program Studi berhasil dihapus!');
    }
}