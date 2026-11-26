<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\InternshipPartner;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicInternshipPartnerController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'type', 'prodi', 'bidang']);

        $query = InternshipPartner::active()->ofType($request->type);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('business_field', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('prodi')) {
            $query->whereJsonContains('study_program_ids', (int) $request->prodi);
        }

        if ($request->filled('bidang')) {
            $query->where('business_field', $request->bidang);
        }

        $prodiNames = StudyProgram::pluck('name', 'id');

        $partners = $query->orderBy('name')->paginate(12)->withQueryString()
            ->through(fn (InternshipPartner $item) => [
                'id' => $item->id,
                'name' => $item->name,
                'business_field' => $item->business_field,
                'location' => $item->location,
                'type' => $item->type,
                'type_label' => $item->type_label,
                'study_programs' => collect($item->study_program_ids ?? [])
                    ->map(fn ($id) => $prodiNames[$id] ?? null)->filter()->values(),
                'website' => $item->website,
                'logo_url' => $item->logo_url,
            ]);

        $active = InternshipPartner::active();

        return Inertia::render('Public/InternshipPartners/Index', [
            'partners' => $partners,
            'filters' => $filters,
            'studyPrograms' => StudyProgram::orderBy('id')->get(['id', 'name']),
            'businessFields' => (clone $active)->distinct()->orderBy('business_field')->pluck('business_field'),
            'stats' => [
                'total' => (clone $active)->count(),
                'cities' => (clone $active)->distinct()->count('location'),
                'fields' => (clone $active)->distinct()->count('business_field'),
            ],
        ]);
    }
}
