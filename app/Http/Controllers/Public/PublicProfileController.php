<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\FacultyProfile;
use App\Models\Staff;
use App\Models\StudyProgram;
use App\Models\Contact;

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
        ];

        return Inertia::render('Public/Profiles/About', [
            'profile' => $profile ? $profile->content : null,
            'statistics' => $statistics
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
}