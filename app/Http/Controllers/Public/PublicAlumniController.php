<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicAlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('prodi')) {
            $query->where('study_program', $request->prodi);
        }

        if ($request->filled('year')) {
            $query->where('graduation_year', $request->year);
        }

        $alumnis = $query->orderBy('graduation_year', 'desc')
                         ->orderBy('name', 'asc')
                         ->paginate(20)
                         ->withQueryString();

        $prodis = Alumni::select('study_program')->distinct()->orderBy('study_program')->pluck('study_program');
        $years = Alumni::select('graduation_year')->distinct()->orderBy('graduation_year', 'desc')->pluck('graduation_year');

        return Inertia::render('Public/Alumni/Index', [
            'alumnis' => $alumnis,
            'filters' => $request->only(['search', 'prodi', 'year']),
            'prodis' => $prodis,
            'years' => $years
        ]);
    }
}