<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\FacultyProfile;
use App\Models\Staff;
use App\Models\StudyProgram;
use App\Models\Department;
use App\Models\Contact;
use App\Models\Alumni;

class PublicProfileController extends Controller
{
    public function tentang()
    {
        $profile = FacultyProfile::first();

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

        $statistics = [
            'dosen' => Staff::where('type', 'Dosen')->where('is_active', true)->count(),
            'tendik' => Staff::where('type', 'Tendik')->where('is_active', true)->count(),
            'prodi_s1' => $s1,
            'prodi_s2' => $s2,
            'prodi_total' => $allStudyPrograms->count(),
            'jurusan' => Department::count(),
            'alumni' => Alumni::count(),
        ];

        $profileContent = $profile ? $profile->content : null;
        if ($profileContent && isset($profileContent['statistik']['data'])) {
            foreach ($profileContent['statistik']['data'] as &$stat) {
                $label = strtolower($stat['label']);
                if (str_contains($label, 'dosen')) $stat['angka'] = (string)$statistics['dosen'];
                if (str_contains($label, 'tendik') || str_contains($label, 'kependidikan')) $stat['angka'] = (string)$statistics['tendik'];
                if (str_contains($label, 's1')) $stat['angka'] = (string)$statistics['prodi_s1'];
                if (str_contains($label, 's2') || str_contains($label, 'magister')) $stat['angka'] = (string)$statistics['prodi_s2'];
                if ($label === 'program studi' || $label === 'prodi') $stat['angka'] = (string)$statistics['prodi_total'];
                if ($label === 'jurusan') $stat['angka'] = (string)$statistics['jurusan'];
                if (str_contains($label, 'alumni') || str_contains($label, 'lulusan')) $stat['angka'] = (string)$statistics['alumni'];
            }
        }

        $dekan = Staff::where('structural_position', 'like', '%Dekan%')
            ->where('structural_position', 'not like', '%Wakil%')
            ->where('is_active', true)
            ->first();

        return Inertia::render('Public/Profiles/About', [
            'profile' => $profileContent,
            'statistics' => $statistics,
            'dekan' => $dekan
        ]);
    }

    public function baganOrganisasi()
    {
        $profile = FacultyProfile::first();

        $baganImage = null;

        if ($profile && isset($profile->content['bagan_organisasi']) && $profile->content['bagan_organisasi']) {
            $path = $profile->content['bagan_organisasi'];

            if (str_starts_with($path, 'images/')) {
                $baganImage = asset($path);
            } else {
                $baganImage = asset('storage/' . $path);
            }
        } else {
            $baganImage = asset('images/bagan-organisasi.webp');
        }

        return Inertia::render('Public/Profiles/OrganizationalChart', [
            'baganImage' => $baganImage
        ]);
    }

    public function kontak()
    {
        $contact = Contact::first();
        return Inertia::render('Public/Profiles/Contacts', [
            'contact' => $contact
        ]);
    }

    public function strukturOrganisasi()
    {
        $profile = FacultyProfile::first();
        $baganImage = null;
        if ($profile && isset($profile->content['bagan_organisasi']) && $profile->content['bagan_organisasi']) {
            $path = $profile->content['bagan_organisasi'];
            $baganImage = str_starts_with($path, 'images/') ? asset($path) : asset('storage/' . $path);
        } else {
            $baganImage = asset('images/bagan-organisasi.webp');
        }

        $fakultas = Staff::where(function ($query) {
            $query->where('structural_position', 'like', '%Dekan%')
                ->orWhere('functional_position', 'like', '%Dekan%')
                ->orWhere('structural_position', 'like', '%Kepala Subbagian Umum%')
                ->orWhere('functional_position', 'like', '%Kepala Subbagian Umum%');
        })->where('is_active', true)->get()->sortBy(function ($staff) {
            $jabatan = $staff->structural_position . ' ' . $staff->functional_position;
            if (str_contains($jabatan, 'Wakil Dekan')) return 2;
            if (str_contains($jabatan, 'Dekan')) return 1;
            if (str_contains($jabatan, 'Kepala Subbagian Umum')) return 3;
            return 4;
        })->values();

        $jurusan = Staff::where('structural_position', 'like', '%Ketua Jurusan%')
            ->where('is_active', true)->orderBy('name', 'asc')->get();

        $studyPrograms = StudyProgram::all();
        $prodi = Staff::where('structural_position', 'like', '%Koordinator Program Studi%')
            ->where('is_active', true)->orderBy('name', 'asc')->get()
            ->map(function ($item) use ($studyPrograms) {
                $jabatan = strtolower($item->structural_position);
                $jurusanStr = 'Umum / Lainnya';
                foreach ($studyPrograms as $sp) {
                    if (str_contains($jabatan, strtolower($sp->name))) {
                        $jurusanStr = $sp->department;
                        break;
                    }
                }
                $item->jurusan = $jurusanStr;
                return $item;
            });

        $lab = Staff::where('structural_position', 'like', '%Kepala Laboratorium%')
            ->where('is_active', true)->orderBy('name', 'asc')->get();

        return Inertia::render('Public/Profiles/Structure', [
            'baganImage' => $baganImage,
            'fakultas' => $fakultas,
            'jurusan' => $jurusan,
            'prodi' => $prodi,
            'lab' => $lab
        ]);
    }
}
