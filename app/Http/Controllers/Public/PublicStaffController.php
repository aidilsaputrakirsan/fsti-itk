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
        $pimpinanRaw = Staff::where(function ($query) {
            $query->where('structural_position', 'like', '%Dekan%')
                ->orWhere('functional_position', 'like', '%Dekan%')
                ->orWhere('structural_position', 'like', '%Kepala Subbagian Umum%')
                ->orWhere('functional_position', 'like', '%Kepala Subbagian Umum%');
        })
            ->where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        $pimpinan = $pimpinanRaw->unique(function ($item) {
            $jabatan = strtolower($item->structural_position . ' ' . $item->functional_position);
            if (str_contains($jabatan, 'wakil dekan 1')) return 'wd1';
            if (str_contains($jabatan, 'wakil dekan 2')) return 'wd2';
            if (str_contains($jabatan, 'dekan')) return 'dekan';
            if (str_contains($jabatan, 'kepala subbagian umum')) return 'kasubbag';
            return $item->id; // Jika jabatan lainnya, biarkan unik berdasarkan ID
        })
            ->sortBy(function ($staff) {
                $jabatan = strtolower($staff->structural_position . ' ' . $staff->functional_position);
                if (str_contains($jabatan, 'wakil dekan')) return 2;
                if (str_contains($jabatan, 'dekan')) return 1;
                if (str_contains($jabatan, 'kepala subbagian umum')) return 3;
                return 4;
            })
            ->values();

        return Inertia::render('Public/Profil/PimpinanFakultas', ['pimpinan' => $pimpinan]);
    }

    public function pimpinanJurusan()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Ketua Jurusan%')
            ->where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->unique('structural_position')
            ->sortBy('name')
            ->values();

        return Inertia::render('Public/Profil/PimpinanJurusan', ['pimpinan' => $pimpinan]);
    }

    public function pimpinanProdi()
    {
        $pimpinanRaw = Staff::where('structural_position', 'like', '%Koordinator Program Studi%')
            ->where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        $pimpinan = $pimpinanRaw->unique(function ($item) {
            return strtolower($item->structural_position);
        })
            ->map(function ($item) {
                $jabatan = strtolower($item->structural_position);

                if (str_contains($jabatan, 'matematika') || str_contains($jabatan, 'fisika') || str_contains($jabatan, 'aktuaria') || str_contains($jabatan, 'statistika')) {
                    $jurusan = 'Sains dan Analitika Data';
                } else {
                    $jurusan = 'Teknik Elektro, Informatika, dan Bisnis';
                }

                $item->jurusan = $jurusan;
                return $item;
            })
            ->sortBy('name')
            ->values();

        return Inertia::render('Public/Profil/PimpinanProdi', ['pimpinan' => $pimpinan]);
    }

    public function pimpinanLaboratorium()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Kepala Laboratorium%')
            ->where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->unique('structural_position')
            ->sortBy('name')
            ->values();

        return Inertia::render('Public/Profil/PimpinanLaboratorium', ['pimpinan' => $pimpinan]);
    }

    public function dosen(Request $request)
    {
        $query = Staff::where('type', 'Dosen')->where('is_active', true);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('nip', 'like', "%{$searchTerm}%")
                    ->orWhereJsonContains('expertise', $searchTerm);
            });
        }

        if ($request->filled('prodi')) {
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
        $groupedData = empty($groupedDosen) ? new \stdClass() : (object) $groupedDosen;
        $prodiList = StudyProgram::orderBy('name', 'asc')->pluck('name')->toArray();

        return Inertia::render('Public/Profil/Dosen', [
            'groupedDosen' => $groupedData,
            'filters' => $request->only(['search', 'prodi']),
            'prodiList' => $prodiList
        ]);
    }

    public function tendik(Request $request)
    {
        $query = Staff::where('type', 'Tendik')->where('is_active', true);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('nip', 'like', '%' . $request->search . '%')
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
