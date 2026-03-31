<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicStaffController extends Controller
{
    // =========================================================
    // 1. MENU PIMPINAN FAKULTAS
    // =========================================================
    public function pimpinanFakultas()
    {
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
        ->values();

        return Inertia::render('Public/Profil/PimpinanFakultas', [
            'pimpinan' => $pimpinan
        ]);
    }

    // =========================================================
    // 2. MENU PIMPINAN JURUSAN
    // =========================================================
    public function pimpinanJurusan()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Ketua Jurusan%')
            ->orderBy('name', 'asc')
            ->get();

        return Inertia::render('Public/Profil/PimpinanJurusan', [
            'pimpinan' => $pimpinan
        ]);
    }

    // =========================================================
    // 3. MENU PIMPINAN PRODI
    // =========================================================
    public function pimpinanProdi()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Koordinator Program Studi%')
            ->orderBy('name', 'asc')
            ->get();

        $pimpinan = $pimpinan->map(function ($item) {
            $jurusan = 'Lainnya';
            $jabatan = $item->structural_position;

            if (str_contains($jabatan, 'Matematika') || str_contains($jabatan, 'Fisika') || str_contains($jabatan, 'Aktuaria') || str_contains($jabatan, 'Statistika')) {
                $jurusan = 'Sains dan Analitika Data';
            } elseif (str_contains($jabatan, 'Informatika') || str_contains($jabatan, 'Sistem Informasi') || str_contains($jabatan, 'Elektro') || str_contains($jabatan, 'Elektronika') || str_contains($jabatan, 'Bisnis Digital')) {
                $jurusan = 'Teknik Elektro, Informatika, dan Bisnis';
            }
            
            $item->jurusan = $jurusan;
            return $item;
        });

        return Inertia::render('Public/Profil/PimpinanProdi', [
            'pimpinan' => $pimpinan
        ]);
    }

    // =========================================================
    // 4. MENU PIMPINAN LABORATORIUM
    // =========================================================
    public function pimpinanLaboratorium()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Kepala Laboratorium%')
            ->orderBy('name', 'asc')
            ->get();

        return Inertia::render('Public/Profil/PimpinanLaboratorium', [
            'pimpinan' => $pimpinan
        ]);
    }

    // =========================================================
    // 5. MENU DOSEN (Dengan Filter, Search, dan Paginasi)
    // =========================================================
    public function dosen(Request $request)
    {
        $query = Staff::where('type', 'Dosen')->where('is_active', true);

        // Filter berdasarkan nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan program studi
        if ($request->filled('prodi')) {
            $prodi = $request->prodi;
            $query->where(function($q) use ($prodi) {
                $q->where('structural_position', 'like', "%{$prodi}%")
                  ->orWhere('functional_position', 'like', "%{$prodi}%")
                  ->orWhereJsonContains('expertise', $prodi); 
            });
        }

        // Paginasi 12 data per halaman
        $dosen = $query->orderBy('name', 'asc')->paginate(12)->withQueryString();

        // Mengambil daftar program studi dari database
        $prodiList = StudyProgram::orderBy('name', 'asc')->pluck('name')->toArray();

        return Inertia::render('Public/Profil/Dosen', [
            'dosen' => $dosen,
            'filters' => $request->only(['search', 'prodi']),
            'prodiList' => $prodiList
        ]);
    }

    // =========================================================
    // 6. MENU TENAGA KEPENDIDIKAN (Dengan Search dan Paginasi)
    // =========================================================
    public function tendik(Request $request)
    {
        $query = Staff::where('type', 'Tendik')->where('is_active', true);

        // Filter berdasarkan nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Paginasi 12 data per halaman
        $tendik = $query->orderBy('name', 'asc')->paginate(12)->withQueryString();

        return Inertia::render('Public/Profil/TenagaKependidikan', [
            'tendik' => $tendik,
            'filters' => $request->only(['search'])
        ]);
    }
}