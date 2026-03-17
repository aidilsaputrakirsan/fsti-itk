<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ZiProfile;
use App\Models\ZiDocument;
use Inertia\Inertia;

class PublicZonaIntegritasController extends Controller
{
    public function index()
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