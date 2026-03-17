<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriPpid;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\ZiProfile;
use App\Models\ZiDocument;
use App\Models\SatisfactionSurvey;
use App\Models\SurveyCategory;

class PublicAdditionalController extends Controller
{
    // ==========================================
    // MODUL PPID
    // ==========================================
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

        // AMBIL DATA DENGAN URUTAN YANG BENAR
        $kategoris = KategoriPpid::with(['dokumen'])
            ->where('jenis_informasi', $jenisAsli)
            ->orderBy('urutan', 'asc') // Menjamin Kategori tampil terurut (1, 2, 3)
            ->get();

        return Inertia::render('Public/PPID/ShowJenis', [
            'kategoris' => $kategoris,
            'jenis_informasi' => $jenisAsli
        ]);
    }

    // ==========================================
    // MODUL ZONA INTEGRITAS
    // ==========================================
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

    // ==========================================
    // MODUL SURVEI KEPUASAN (SKM)
    // ==========================================
    public function survei()
    {
        // Mengambil semua aspek penilaian yang aktif dari tabel survey_categories
        $categories = SurveyCategory::where('is_active', true)->get();

        return Inertia::render('Public/Survei/Index', [
            'categories' => $categories
        ]);
    }

    public function storeSurvei(Request $request)
    {
        // Validasi inputan dari form Vue
        $validated = $request->validate([
            'respondent_name' => 'nullable|string|max:255',
            'respondent_email' => 'nullable|email|max:255',
            'respondent_type' => 'required|string|max:255',
            'service_category' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string',
        ]);

        // Simpan ke database
        SatisfactionSurvey::create($validated);

        // Kembalikan ke halaman form dengan pesan sukses
        return redirect()->back()->with('success', 'Terima kasih atas partisipasi Anda!');
    }
}
