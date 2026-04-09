<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SatisfactionSurvey;
use App\Models\SurveyCategory;
use Inertia\Inertia;

class PublicSurveiController extends Controller
{
    public function index()
    {
        // Mengambil semua aspek penilaian yang aktif dari tabel survey_categories
        $categories = SurveyCategory::where('is_active', true)->get();

        return Inertia::render('Public/Survei/Index', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
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