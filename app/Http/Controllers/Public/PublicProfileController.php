<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Contact;
use App\Models\TentangFakultas;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
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

    public function dosen(Request $request)
    {
        $query = Staff::where('type', 'Dosen')->where('is_active', true);

        // Filter berdasarkan nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan program studi (dicari dari jabatan atau keahlian)
        if ($request->filled('prodi')) {
            $prodi = $request->prodi;
            $query->where(function ($q) use ($prodi) {
                $q->where('structural_position', 'like', "%{$prodi}%")
                    ->orWhere('functional_position', 'like', "%{$prodi}%")
                    ->orWhereJsonContains('expertise', $prodi);
            });
        }

        // Paginasi 12 data per halaman, pertahankan parameter pencarian di URL
        $dosen = $query->orderBy('name', 'asc')->paginate(12)->withQueryString();

        // Mengambil daftar program studi dari database untuk opsi filter dropdown
        $prodiList = StudyProgram::orderBy('name', 'asc')->pluck('name')->toArray();

        return Inertia::render('Public/Profil/Dosen', [
            'dosen' => $dosen,
            'filters' => $request->only(['search', 'prodi']),
            'prodiList' => $prodiList
        ]);
    }

    public function tendik(Request $request)
    {
        $query = Staff::where('type', 'Tendik')->where('is_active', true);

        // Filter berdasarkan nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Paginasi 12 data per halaman, pertahankan parameter pencarian di URL
        $tendik = $query->orderBy('name', 'asc')->paginate(12)->withQueryString();

        return Inertia::render('Public/Profil/TenagaKependidikan', [
            'tendik' => $tendik,
            'filters' => $request->only(['search'])
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
