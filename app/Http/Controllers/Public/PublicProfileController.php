<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Contact;
use App\Models\TentangFakultas;
use App\Models\StudyProgram;
use Inertia\Inertia;

class PublicProfileController extends Controller
{
    public function tentang()
    {
        $tentangData = TentangFakultas::first();
        $tentangContent = $tentangData ? $tentangData->content : null;

        $statistik = [
            'dosen' => Staff::where('type', 'Dosen')->where('is_active', true)->count(),
            'tendik' => Staff::where('type', 'Tendik')->where('is_active', true)->count(),
            'prodi' => StudyProgram::count(),
        ];

        return inertia('Public/Profil/Tentang', [
            'tentang' => $tentangContent,
            'statistik' => $statistik
        ]);
    }

    public function baganOrganisasi()
    {
        $profil = TentangFakultas::first();
        $baganImage = $profil ? $profil->bagan_organisasi_image : null;

        return inertia('Public/Profil/BaganOrganisasi', [
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