<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Inertia\Inertia;

class PublicStaffController extends Controller
{
    // 1. MENU PIMPINAN FAKULTAS
    public function pimpinanFakultas()
    {
        // 1. Ambil staff dengan kata kunci "Dekan" atau "Kepala Subbagian Umum"
        $pimpinan = Staff::where(function ($query) {
            $query->where('structural_position', 'like', '%Dekan%')
                ->orWhere('functional_position', 'like', '%Dekan%')
                ->orWhere('structural_position', 'like', '%Kepala Subbagian Umum%')
                ->orWhere('functional_position', 'like', '%Kepala Subbagian Umum%');
        })
            ->get()
            ->sortBy(function ($staff) {
                $jabatan = $staff->structural_position . ' ' . $staff->functional_position;

                if (str_contains($jabatan, 'Wakil Dekan')) return 2; // Urutan 2: Wakil Dekan
                if (str_contains($jabatan, 'Dekan')) return 1;       // Urutan 1: Dekan (Paling Atas)
                if (str_contains($jabatan, 'Kepala Subbagian Umum')) return 3; // Urutan 3: Kasubbag

                return 4;
            })
            ->values(); // Reset indeks array agar terbaca benar di Vue/JSON

        return Inertia::render('Public/Profil/PimpinanFakultas', [
            'pimpinan' => $pimpinan
        ]);
    }
    // 2. MENU PIMPINAN JURUSAN
    public function pimpinanJurusan()
    {
        // Cari staff yang jabatannya mengandung kata "Ketua Jurusan"
        $pimpinan = Staff::where('structural_position', 'like', '%Ketua Jurusan%')
            ->orderBy('name')
            ->get();

        return Inertia::render('Public/Profil/PimpinanJurusan', [
            'pimpinan' => $pimpinan
        ]);
    }

    // 3. MENU PIMPINAN PRODI
    public function pimpinanProdi()
    {
        // Cari staff yang jabatannya mengandung kata "Koordinator Program Studi"
        $pimpinan = Staff::where('structural_position', 'like', '%Koordinator Program Studi%')
            ->orderBy('name')
            ->get();

        // Di PimpinanProdi.vue Anda butuh properti tambahan 'jurusan'.
        // Karena di seeder Anda tidak ada kolom jurusan khusus dosen, 
        // kita tambahkan secara virtual/mapping di sini berdasarkan nama prodinya.
        $pimpinan = $pimpinan->map(function ($item) {
            $jurusan = 'Lainnya';
            if (str_contains($item->structural_position, 'Matematika') || str_contains($item->structural_position, 'Fisika') || str_contains($item->structural_position, 'Aktuaria') || str_contains($item->structural_position, 'Statistika')) {
                $jurusan = 'Sains dan Analitika Data';
            } elseif (str_contains($item->structural_position, 'Informatika') || str_contains($item->structural_position, 'Sistem Informasi') || str_contains($item->structural_position, 'Elektro') || str_contains($item->structural_position, 'Elektronika') || str_contains($item->structural_position, 'Bisnis Digital')) {
                $jurusan = 'Teknik Elektro, Informatika, dan Bisnis';
            }
            $item->jurusan = $jurusan;
            return $item;
        });

        return Inertia::render('Public/Profil/PimpinanProdi', [
            'pimpinan' => $pimpinan
        ]);
    }

    // 4. MENU PIMPINAN LABORATORIUM
    public function pimpinanLaboratorium()
    {
        // Cari staff yang jabatannya mengandung kata "Kepala Laboratorium"
        $pimpinan = Staff::where('structural_position', 'like', '%Kepala Laboratorium%')
            ->orderBy('name')
            ->get();

        return Inertia::render('Public/Profil/PimpinanLaboratorium', [
            'pimpinan' => $pimpinan
        ]);
    }

    // 5. MENU DOSEN (Semua Dosen)
    public function dosen()
    {
        // Ambil semua yang tipe-nya Dosen
        $dosen = Staff::where('type', 'Dosen')->orderBy('name')->get();

        return Inertia::render('Public/Profil/Dosen', [
            'dosen' => $dosen
        ]);
    }

    // 6. MENU TENAGA KEPENDIDIKAN (Semua Tendik)
    public function tendik()
    {
        // Ambil semua yang tipe-nya Tendik
        $tendik = Staff::where('type', 'Tendik')->orderBy('name')->get();

        return Inertia::render('Public/Profil/TenagaKependidikan', [
            'tendik' => $tendik
        ]);
    }
}
