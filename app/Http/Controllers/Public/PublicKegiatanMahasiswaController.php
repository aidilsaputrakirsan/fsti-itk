<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KegiatanMahasiswa;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class PublicKegiatanMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');

        $kegiatanRaw = KegiatanMahasiswa::orderBy('start_date', 'desc')->get();

        $groupedKegiatan = $kegiatanRaw->groupBy(function($item) {
            return Carbon::parse($item->start_date)->translatedFormat('F Y'); 
        });

        return Inertia::render('Public/Kegiatan/Kegiatan', [
            'groupedKegiatan' => $groupedKegiatan
        ]);
    }
}