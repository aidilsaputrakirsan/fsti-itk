<?php

namespace App\Http\Controllers;

use App\Models\KategoriPpid;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\ZiProfile;
use App\Models\ZiDocument;

class PublicAdditionalController extends Controller
{
    public function ppid()
    {
        // Ambil semua kategori beserta dokumennya
        $kategoris = KategoriPpid::with(['dokumen'])->get();

        // Kelompokkan berdasarkan jenis_informasi
        $jenisInformasi = $kategoris->groupBy('jenis_informasi')->map(function ($items, $key) {
            return [
                'jenis' => $key,
                'slug' => Str::slug($key),
                'total_kategori' => $items->count(),
                'total_dokumen' => $items->sum(fn($kat) => $kat->dokumen->count()),
            ];
        })->values();

        return Inertia::render('Public/PPID/Index', [
            'jenisInformasi' => $jenisInformasi
        ]);
    }

    public function showJenis($slug)
    {
        $jenisInformasiList = KategoriPpid::select('jenis_informasi')
            ->distinct()
            ->pluck('jenis_informasi');

        $jenisAsli = null;

        foreach ($jenisInformasiList as $jenis) {
            if (Str::slug($jenis) === $slug) {
                $jenisAsli = $jenis;
                break;
            }
        }

        // Jika slug tidak cocok dengan data apapun, tampilkan 404
        if (!$jenisAsli) abort(404);

        // 2. AMBIL DATA DENGAN URUTAN YANG BENAR
        $kategoris = KategoriPpid::with(['dokumen'])
            ->where('jenis_informasi', $jenisAsli)
            ->orderBy('urutan', 'asc') // Menjamin Kategori tampil terurut (1, 2, 3)
            ->get();

        return Inertia::render('Public/PPID/ShowJenis', [
            'kategoris' => $kategoris,
            'jenis_informasi' => $jenisAsli
        ]);
    }

    public function zonaIntegritas()
    {
        // Ambil profil ZI (jika belum ada, kembalikan objek kosong)
        $profile = ZiProfile::first() ?? new ZiProfile();

        // Ambil semua dokumen ZI urut dari yang terbaru
        $documents = ZiDocument::latest()->get();

        return Inertia::render('Public/ZonaIntegritas/Index', [
            'profile' => $profile,
            'documents' => $documents
        ]);
    }
}
