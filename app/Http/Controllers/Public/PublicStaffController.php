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

        return Inertia::render('Public/Profiles/FacultyLeaders', [
            'leaders' => $pimpinan
        ]);
    }

    public function pimpinanJurusan()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Ketua Jurusan%')
            ->where('is_active', true)->orderBy('name', 'asc')->get();

        return Inertia::render('Public/Profiles/DepartmentLeaders', [
            'leaders' => $pimpinan
        ]);
    }

    public function pimpinanProdi()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Koordinator Program Studi%')
            ->where('is_active', true)->orderBy('name', 'asc')->get();

        $pimpinan = $pimpinan->map(function ($item) {
            $jabatan = strtolower($item->structural_position);

            if (str_contains($jabatan, 'matematika') || str_contains($jabatan, 'fisika') || str_contains($jabatan, 'aktuaria') || str_contains($jabatan, 'statistika')) {
                $jurusan = 'Sains dan Analitika Data';
            } else {
                $jurusan = 'Teknik Elektro, Informatika, dan Bisnis';
            }

            $item->jurusan = $jurusan;
            return $item;
        });

        return Inertia::render('Public/Profiles/ProgramLeaders', [
            'leaders' => $pimpinan
        ]);
    }

    public function pimpinanLaboratorium()
    {
        $pimpinan = Staff::where('structural_position', 'like', '%Kepala Laboratorium%')
            ->where('is_active', true)->orderBy('name', 'asc')->get();

        return Inertia::render('Public/Profiles/LabLeaders', [
            'leaders' => $pimpinan
        ]);
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

        if ($request->filled('program')) {
            $query->where('functional_position', 'like', "%{$request->program}%");
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

        return Inertia::render('Public/Profiles/Lecturers', [
            'groupedLecturers' => $groupedData,
            // PERBAIKAN: Ubah 'prodi' menjadi 'program'
            'filters' => $request->only(['search', 'program']),
            'studyPrograms' => $prodiList
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

        return Inertia::render('Public/Profiles/SupportStaff', [
            'staff' => $tendik,
            'filters' => $request->only(['search'])
        ]);
    }
}
