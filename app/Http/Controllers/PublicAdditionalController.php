<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriPpid;
use Illuminate\Support\Str;
use Inertia\Inertia;

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
                // MENGAMBIL IKON DARI DATABASE (Kategori pertama dalam grup)
                'icon' => $items->first()->icon
            ];
        })->values();

        return Inertia::render('Public/PPID/Index', [
            'jenisInformasi' => $jenisInformasi
        ]);
    }

    public function showJenis($slug)
    {
        // 1. Cari dulu jenis aslinya berdasarkan slug
        $semuaKategori = KategoriPpid::all();
        $jenisAsli = null;
        foreach ($semuaKategori as $kat) {
            if (Str::slug($kat->jenis_informasi) === $slug) {
                $jenisAsli = $kat->jenis_informasi;
                break;
            }
        }

        if (!$jenisAsli) abort(404);

        // 2. AMBIL DATA DENGAN URUTAN YANG BENAR
        $kategoris = KategoriPpid::with(['dokumen'])
            ->where('jenis_informasi', $jenisAsli)
            ->orderBy('urutan', 'asc') // Ini kunci agar urutan 1, 2, 3 berfungsi
            ->get();

        return Inertia::render('Public/PPID/ShowJenis', [
            'kategoris' => $kategoris,
            'jenis_informasi' => $jenisAsli
        ]);
    }
}
