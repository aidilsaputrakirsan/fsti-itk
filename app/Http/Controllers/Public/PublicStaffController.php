<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicStaffController extends Controller
{
    public function pimpinanFakultas()
    {
        $pimpinan = Staff::where(function ($query) {
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

        return Inertia::render('Public/Profil/PimpinanFakultas', ['pimpinan' => $pimpinan]);
    }

    public function pimpinanJurusan()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Ketua Jurusan%')
            ->where('is_active', true)->orderBy('name', 'asc')->get();
        return Inertia::render('Public/Profil/PimpinanJurusan', ['pimpinan' => $pimpinan]);
    }

    public function pimpinanProdi()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Koordinator Program Studi%')
            ->where('is_active', true)->orderBy('name', 'asc')->get();

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

        return Inertia::render('Public/Profil/PimpinanProdi', ['pimpinan' => $pimpinan]);
    }

    public function pimpinanLaboratorium()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Kepala Laboratorium%')
            ->where('is_active', true)->orderBy('name', 'asc')->get();
        return Inertia::render('Public/Profil/PimpinanLaboratorium', ['pimpinan' => $pimpinan]);
    }

    // ====================================================================
    // DOSEN PUBLIK
    // ====================================================================
    public function dosen(Request $request)
    {
        $query = Staff::where('type', 'Dosen')->where('is_active', true);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhereJsonContains('expertise', $searchTerm);
            });
        }

        if ($request->filled('prodi')) {
            // HANYA MENCARI DI JABATAN AGAR PRODI TIDAK BOCOR
            $query->where('functional_position', 'like', "%{$request->prodi}%");
        }

        $dosenRaw = $query->orderBy('name', 'asc')->get();

        $groupedDosen = [];
        foreach ($dosenRaw as $dosen) {
            $jabatan = $dosen->functional_position ?? '';
            $prodiName = 'Umum / Lainnya'; 
            if (str_contains($jabatan, 'Program Studi')) {
                $prodiName = trim(str_replace('Dosen Program Studi', '', $jabatan));
            }
            $groupedDosen[$prodiName][] = $dosen;
        }

        ksort($groupedDosen);

        // Mencegah error 'Missing Prop' di Vue jika data kosong
        $groupedData = empty($groupedDosen) ? new \stdClass() : (object) $groupedDosen;

        $prodiList = StudyProgram::orderBy('name', 'asc')->pluck('name')->toArray();

        return Inertia::render('Public/Profil/Dosen', [
            'groupedDosen' => $groupedData, 
            'filters' => $request->only(['search', 'prodi']),
            'prodiList' => $prodiList
        ]);
    }

    // ====================================================================
    // TENDIK PUBLIK
    // ====================================================================
    public function tendik(Request $request)
    {
        $query = Staff::where('type', 'Tendik')->where('is_active', true);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('functional_position', 'like', '%' . $request->search . '%')
                  ->orWhere('structural_position', 'like', '%' . $request->search . '%');
            });
        }

        $tendik = $query->orderBy('name', 'asc')->paginate(12)->withQueryString();

        return Inertia::render('Public/Profil/TenagaKependidikan', [
            'tendik' => $tendik,
            'filters' => $request->only(['search'])
        ]);
    }
}