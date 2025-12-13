<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicAdditionalController extends Controller
{
    public function ppid()
    {
        $documents = \App\Models\PpidDocument::where('is_active', true)
            ->orderBy('category')
            ->get()
            ->groupBy('category');
            
        return \Inertia\Inertia::render('Public/PPID/Index', [
            'documents' => $documents
        ]);
    }

    public function zonaIntegritas()
    {
        $policies = \App\Models\IntegrityZone::where('category', '!=', 'Berita ZI')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();
            
        $news = \App\Models\IntegrityZone::where('category', 'Berita ZI')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        return \Inertia\Inertia::render('Public/ZonaIntegritas/Index', [
            'policies' => $policies,
            'news' => $news
        ]);
    }

    public function alumni()
    {
        $tracers = \App\Models\AlumniTracer::where('is_active', true)
            ->orderBy('year', 'desc')
            ->get();

        return \Inertia\Inertia::render('Public/Alumni/Index', [
            'tracers' => $tracers
        ]);
    }

    public function survei()
    {
        return \Inertia\Inertia::render('Public/Survei/Index');
    }

    public function storeSurvei(Request $request)
    {
        $validated = $request->validate([
            'respondent_name' => 'nullable|string|max:255',
            'respondent_email' => 'nullable|email|max:255',
            'respondent_type' => 'required|string',
            'service_category' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string'
        ]);

        \App\Models\SatisfactionSurvey::create($validated);

        return redirect()->back()->with('success', 'Terima kasih atas masukan Anda!');
    }

    public function layanan()
    {
        $services = \App\Models\InternalService::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        return \Inertia\Inertia::render('Public/Layanan/Index', [
            'services' => $services
        ]);
    }
}
