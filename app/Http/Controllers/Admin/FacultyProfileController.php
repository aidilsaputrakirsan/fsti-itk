<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacultyProfile;
use App\Models\Staff;
use App\Models\StudyProgram;
use App\Models\Alumni;
use App\Models\Department; 
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class FacultyProfileController extends Controller
{
    public function edit()
    {
        $page = FacultyProfile::firstOrCreate(
            ['id' => 1],
            [
                'content' => [
                    'statistik' => ['deskripsi' => '', 'data' => []],
                    'tugas_fungsi' => ['tugas' => '', 'fungsi' => []],
                    'visi_misi' => ['visi' => '', 'misi_tagline' => '', 'misi' => []],
                    'bagan_organisasi' => null,
                    'pmb_link' => '',
                    'tracer_study_link' => ''
                ]
            ]
        );

        $content = $page->content;

        $countDosen = Staff::where('type', 'Dosen')->where('is_active', true)->count();
        $countTendik = Staff::where('type', 'Tendik')->where('is_active', true)->count();
        $countAlumni = Alumni::count();
        $countJurusan = Department::count();

        $allStudyPrograms = StudyProgram::all();
        $s1 = 0;
        $s2 = 0;

        foreach ($allStudyPrograms as $p) {
            $degree = strtoupper($p->degree ?? '');
            $name = strtolower($p->name);

            if ($degree === 'S2' || str_contains($name, 's2') || str_contains($name, 'magister')) {
                $s2++;
            } else {
                $s1++;
            }
        }

        if (isset($content['statistik']['data'])) {
            foreach ($content['statistik']['data'] as &$stat) {
                $label = strtolower($stat['label']);
                if (str_contains($label, 'dosen')) $stat['angka'] = (string)$countDosen;
                if (str_contains($label, 'tendik') || str_contains($label, 'kependidikan')) $stat['angka'] = (string)$countTendik;
                if (str_contains($label, 's1')) $stat['angka'] = (string)$s1;
                if (str_contains($label, 's2') || str_contains($label, 'magister')) $stat['angka'] = (string)$s2;
                if ($label === 'program studi' || $label === 'prodi') $stat['angka'] = (string)$allStudyPrograms->count();
                if (str_contains($label, 'alumni') || str_contains($label, 'lulusan')) $stat['angka'] = (string)$countAlumni;
                if ($label === 'jurusan') $stat['angka'] = (string)$countJurusan;
            }
        }

        $page->content = $content;

        return Inertia::render('Admin/FacultyProfiles/Edit', [
            'profile' => $page
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|array',
            'content.pmb_link' => 'nullable|url',
            'content.tracer_study_link' => 'nullable|url',
            'bagan_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $profile = FacultyProfile::first();
        $content = $request->content;

        if ($request->hasFile('bagan_image')) {
            if (isset($profile->content['bagan_organisasi']) && !str_starts_with($profile->content['bagan_organisasi'], 'images/')) {
                Storage::disk('public')->delete($profile->content['bagan_organisasi']);
            }
            $path = $request->file('bagan_image')->store('profiles', 'public');
            $content['bagan_organisasi'] = $path;
        } else {
            if ($profile && isset($profile->content['bagan_organisasi'])) {
                $content['bagan_organisasi'] = $profile->content['bagan_organisasi'];
            }
        }

        FacultyProfile::updateOrCreate(['id' => 1], ['content' => $content]);

        return redirect()->back()->with('success', 'Profil Fakultas berhasil diperbarui!');
    }
}