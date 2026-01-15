<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicProfileController extends Controller
{
    public function visiMisi()
    {
        $visi = StaticPage::where('key', 'visi')->first();
        $misi = StaticPage::where('key', 'misi')->first();

        return Inertia::render('Public/Profil/VisiMisi', [
            'visiText' => $visi ? $visi->content : '',
            'misiItems' => $misi ? $misi->content : [],
        ]);
    }

    public function baganOrganisasi()
    {
        $bagan = StaticPage::where('key', 'bagan-organisasi')->first();

        return Inertia::render('Public/Profil/BaganOrganisasi', [
            'baganImage' => $bagan ? $bagan->image_path : null,
        ]);
    }

    public function pimpinanFakultas()
    {
        $staff = Staff::where('category', 'Pimpinan Fakultas')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Public/Profil/PimpinanFakultas', [
            'pimpinan' => $staff
        ]);
    }

    public function pimpinanJurusan()
    {
        $staff = Staff::where('category', 'Pimpinan Jurusan')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Public/Profil/PimpinanJurusan', [
            'pimpinan' => $staff
        ]);
    }

    public function pimpinanProdi()
    {
        $staff = Staff::where('category', 'Pimpinan Prodi')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Public/Profil/PimpinanProdi', [
            'pimpinan' => $staff
        ]);
    }

    public function pimpinanLaboratorium()
    {
        $staff = Staff::where('category', 'Pimpinan Laboratorium')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Public/Profil/PimpinanLaboratorium', [
            'pimpinan' => $staff
        ]);
    }

    public function dosen()
    {
        // Fetch all active dosen. 
        // We pass them all to Vue because the current Vue implementation 
        // has a nice client-side filtering system.
        $dosen = Staff::where('category', 'Dosen')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return Inertia::render('Public/Profil/Dosen', [
            'dosenList' => $dosen
        ]);
    }

    public function tendik()
    {
        $staff = Staff::where('category', 'Tenaga Kependidikan')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Public/Profil/TenagaKependidikan', [
            'staffList' => $staff
        ]);
    }
}
