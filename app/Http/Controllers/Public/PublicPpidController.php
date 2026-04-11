<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KategoriPpid;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PublicPpidController extends Controller
{
    public function index()
    {
        $kategoris = KategoriPpid::with(['dokumen'])->get();

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

    public function show($slug)
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

        if (!$jenisAsli) abort(404);

        $kategoris = KategoriPpid::with(['dokumen'])
            ->where('jenis_informasi', $jenisAsli)
            ->orderBy('urutan', 'asc') 
            ->get();

        return Inertia::render('Public/PPID/ShowJenis', [
            'kategoris' => $kategoris,
            'jenis_informasi' => $jenisAsli
        ]);
    }
}