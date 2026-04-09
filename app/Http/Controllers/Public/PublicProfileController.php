<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\TentangFakultas;
use App\Models\Staff;
use App\Models\StudyProgram;
use App\Models\Contact;

class PublicProfileController extends Controller
{
    public function tentang()
    {
        $tentang = TentangFakultas::first();

        $allProdi = StudyProgram::all();
        $s1 = 0;
        $s2 = 0;

        foreach ($allProdi as $p) {
            $level = $p->level ?? '';
            $name = strtolower($p->name);

            if (strtoupper($level) === 'S1' || (!str_contains($name, 's2') && !str_contains($name, 'magister') && strtoupper($level) !== 'S2')) {
                $s1++;
            } else {
                $s2++;
            }
        }

        $statistik = [
            'dosen' => Staff::where('type', 'Dosen')->where('is_active', true)->count(),
            'tendik' => Staff::where('type', 'Tendik')->where('is_active', true)->count(),
            'prodi_s1' => $s1,
            'prodi_s2' => $s2,
            'prodi_total' => $allProdi->count(),
        ];

        return Inertia::render('Public/Profil/Tentang', [
            'tentang' => $tentang ? $tentang->content : null,
            'statistik' => $statistik
        ]);
    }

    public function baganOrganisasi()
    {
        $tentang = TentangFakultas::first();

        $baganImage = null;

        if ($tentang && isset($tentang->content['bagan_organisasi']) && $tentang->content['bagan_organisasi']) {
            $path = $tentang->content['bagan_organisasi'];

            if (str_starts_with($path, 'images/')) {
                $baganImage = asset($path);
            } else {
                $baganImage = asset('storage/' . $path);
            }
        } else {
            $baganImage = asset('images/bagan-organisasi.webp');
        }

        return Inertia::render('Public/Profil/BaganOrganisasi', [
            'baganImage' => $baganImage
        ]);
    }

    public function kontak()
    {
        $contact = Contact::first();
        return Inertia::render('Public/Profil/Kontak', [
            'contact' => $contact
        ]);
    }
}
