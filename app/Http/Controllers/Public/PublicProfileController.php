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
        $tentangData = \App\Models\TentangFakultas::first();

        $tentangContent = $tentangData ? $tentangData->content : null;

        $statistik = [
            'dosen' => \App\Models\Staff::where('type', 'Dosen')->where('is_active', true)->count(),
            'tendik' => \App\Models\Staff::where('type', 'Tendik')->where('is_active', true)->count(),
            'prodi' => \App\Models\StudyProgram::count(),
        ];

        return inertia('Public/Profil/Tentang', [
            'tentang' => $tentangContent,
            'statistik' => $statistik
        ]);
    }

    public function baganOrganisasi()
    {
        // Ambil data profil fakultas dari database
        $profil = \App\Models\TentangFakultas::first();

        // Ambil URL gambar bagan organisasi jika ada
        $baganImage = null;
        if ($profil && $profil->bagan_organisasi_image) {
            $baganImage = $profil->bagan_organisasi_image;
        }

        return inertia('Public/Profil/BaganOrganisasi', [
            'baganImage' => $baganImage
        ]);
    }

    // public function pimpinanFakultas()
    // {
    //     $staff = Staff::where('category', 'Pimpinan Fakultas')
    //         ->where('is_active', true)
    //         ->orderBy('sort_order')
    //         ->get();

    //     return Inertia::render('Public/Profil/PimpinanFakultas', [
    //         'pimpinan' => $staff
    //     ]);
    // }

    // public function pimpinanJurusan()
    // {
    //     $staff = Staff::where('category', 'Pimpinan Jurusan')
    //         ->where('is_active', true)
    //         ->orderBy('sort_order')
    //         ->get();

    //     return Inertia::render('Public/Profil/PimpinanJurusan', [
    //         'pimpinan' => $staff
    //     ]);
    // }

    // public function pimpinanProdi()
    // {
    //     $staff = Staff::where('category', 'Pimpinan Prodi')
    //         ->where('is_active', true)
    //         ->orderBy('sort_order')
    //         ->get();

    //     return Inertia::render('Public/Profil/PimpinanProdi', [
    //         'pimpinan' => $staff
    //     ]);
    // }

    // public function pimpinanLaboratorium()
    // {
    //     $staff = Staff::where('category', 'Pimpinan Laboratorium')
    //         ->where('is_active', true)
    //         ->orderBy('sort_order')
    //         ->get();

    //     return Inertia::render('Public/Profil/PimpinanLaboratorium', [
    //         'pimpinan' => $staff
    //     ]);
    // }

    // public function dosen()
    // {
    //     $dosen = Staff::where('category', 'Dosen')
    //         ->where('is_active', true)
    //         ->orderBy('sort_order')
    //         ->orderBy('name')
    //         ->get();

    //     return Inertia::render('Public/Profil/Dosen', [
    //         'dosenList' => $dosen
    //     ]);
    // }

    // public function tendik()
    // {
    //     $staff = Staff::where('category', 'Tenaga Kependidikan')
    //         ->where('is_active', true)
    //         ->orderBy('sort_order')
    //         ->get();

    //     return Inertia::render('Public/Profil/TenagaKependidikan', [
    //         'staffList' => $staff
    //     ]);
    // }

    public function kontak()
    {
        $contact = Contact::first();

        return Inertia::render('Public/Profil/Kontak', [
            'contact' => $contact
        ]);
    }
}
