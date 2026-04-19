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
                    'tracer_study_link' => '',
                    'fasilitas' => [
                        ['nama' => 'Co Learning Space', 'deskripsi' => 'Ruang nyaman untuk belajar bersama, berdiskusi, dan bertukar ide.', 'gambar' => 'https://placehold.co/800x600/2F4DD3/FFFFFF?text=Co+Learning+Space'],
                        ['nama' => 'English Speaking Zone', 'deskripsi' => 'Area khusus untuk melatih kemampuan berbahasa Inggris.', 'gambar' => 'https://placehold.co/600x600/2F4DD3/FFFFFF?text=English+Zone'],
                        ['nama' => 'Ruang Kelas', 'deskripsi' => 'Ruang belajar tatap muka yang interaktif dan nyaman.', 'gambar' => 'https://placehold.co/600x600/2F4DD3/FFFFFF?text=Ruang+Kelas'],
                        ['nama' => 'Lab Inovasi Digital', 'deskripsi' => 'Tempat mengembangkan kreativitas karya digital.', 'gambar' => 'https://placehold.co/600x600/2F4DD3/FFFFFF?text=Lab+Inovasi+Digital'],
                        ['nama' => 'Lab Sistem Cerdas', 'deskripsi' => 'Fasilitas eksplorasi dan pengembangan kecerdasan buatan.', 'gambar' => 'https://placehold.co/600x600/2F4DD3/FFFFFF?text=Lab+Sistem+Cerdas'],
                        ['nama' => 'Lab Komputasi dan Data', 'deskripsi' => 'Area praktik pendukung pemrograman dan komputasi pengolahan data.', 'gambar' => 'https://placehold.co/800x600/2F4DD3/FFFFFF?text=Lab+Komputasi+%26+Data'],
                        ['nama' => 'Lab Fisika Dasar', 'deskripsi' => 'Tempat pelaksanaan praktikum dan eksperimen fisika tingkat dasar.', 'gambar' => 'https://placehold.co/800x600/2F4DD3/FFFFFF?text=Lab+Fisika+Dasar'],
                        ['nama' => 'Lab Fisika Lanjut', 'deskripsi' => 'Fasilitas eksperimen dan analisis fisika untuk penerapan tingkat lanjut.', 'gambar' => 'https://placehold.co/800x600/2F4DD3/FFFFFF?text=Lab+Fisika+Lanjut'],
                        ['nama' => 'Masjid', 'deskripsi' => 'Fasilitas tempat ibadah yang tenang dan nyaman di lingkungan kampus.', 'gambar' => 'https://placehold.co/800x600/2F4DD3/FFFFFF?text=Masjid+Kampus'],
                        ['nama' => 'Perpustakaan', 'deskripsi' => 'Pusat pencarian referensi, buku, dan literatur pendukung studi mahasiswa.', 'gambar' => 'https://placehold.co/800x600/2F4DD3/FFFFFF?text=Perpustakaan']
                    ]
                ]
            ]
        );

        $content = $page->content;

        if (!isset($content['fasilitas'])) {
            $content['fasilitas'] = [];
        }

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
            'content.fasilitas' => 'nullable|array',
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

        // Proses Fasilitas
        $fasilitas = $request->input('content.fasilitas', []);
        foreach ($fasilitas as $index => $item) {
            if ($request->hasFile("content.fasilitas.{$index}.gambar")) {
                $file = $request->file("content.fasilitas.{$index}.gambar");
                
                if (isset($profile->content['fasilitas'][$index]['gambar']) && 
                    !str_starts_with($profile->content['fasilitas'][$index]['gambar'], 'images/') &&
                    !str_starts_with($profile->content['fasilitas'][$index]['gambar'], 'http')) {
                    Storage::disk('public')->delete($profile->content['fasilitas'][$index]['gambar']);
                }
                
                $path = $file->store('fasilitas', 'public');
                $fasilitas[$index]['gambar'] = $path;
            } else {
                $fasilitas[$index]['gambar'] = $item['gambar'] ?? ($profile->content['fasilitas'][$index]['gambar'] ?? null);
            }
        }
        $content['fasilitas'] = $fasilitas;

        FacultyProfile::updateOrCreate(['id' => 1], ['content' => $content]);

        return redirect()->back()->with('success', 'Profil Fakultas berhasil diperbarui!');
    }
}