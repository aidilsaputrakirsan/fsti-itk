<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipPartner;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class InternshipPartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = InternshipPartner::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('business_field', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $prodiNames = StudyProgram::pluck('name', 'id');

        $partners = $query->orderBy('name')->paginate(15)->withQueryString()
            ->through(fn (InternshipPartner $item) => [
                'id' => $item->id,
                'name' => $item->name,
                'business_field' => $item->business_field,
                'location' => $item->location,
                'type_label' => $item->type_label,
                'study_programs' => collect($item->study_program_ids ?? [])
                    ->map(fn ($id) => $prodiNames[$id] ?? null)->filter()->values(),
                'logo_url' => $item->logo_url,
                'is_active' => $item->is_active,
            ]);

        return Inertia::render('Admin/InternshipPartners/Index', [
            'partners' => $partners,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/InternshipPartners/Create', $this->formOptions());
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('internship_partners', 'public');
        }

        InternshipPartner::create($data);

        return redirect()->route('admin.internship-partners.index')
            ->with('success', 'Mitra KP/Magang berhasil ditambahkan.');
    }

    public function edit(InternshipPartner $internshipPartner)
    {
        return Inertia::render('Admin/InternshipPartners/Edit', [
            ...$this->formOptions(),
            'partner' => [
                ...$internshipPartner->only(['id', 'name', 'business_field', 'location', 'type', 'website', 'is_active']),
                'study_program_ids' => $internshipPartner->study_program_ids ?? [],
                'logo_url' => $internshipPartner->logo_url,
            ],
        ]);
    }

    public function update(Request $request, InternshipPartner $internshipPartner)
    {
        $data = $this->validated($request);

        if ($request->hasFile('logo') || $request->boolean('remove_logo')) {
            $this->deleteLogo($internshipPartner);
            $data['logo'] = $request->hasFile('logo')
                ? $request->file('logo')->store('internship_partners', 'public')
                : null;
        }

        $internshipPartner->update($data);

        return redirect()->route('admin.internship-partners.index')
            ->with('success', 'Mitra KP/Magang berhasil diperbarui.');
    }

    public function destroy(InternshipPartner $internshipPartner)
    {
        $this->deleteLogo($internshipPartner);
        $internshipPartner->delete();

        return redirect()->route('admin.internship-partners.index')
            ->with('success', 'Mitra KP/Magang berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'business_field' => 'required|string|max:150',
            'location' => 'required|string|max:150',
            'type' => ['required', Rule::in(array_keys(InternshipPartner::TYPES))],
            'study_program_ids' => 'nullable|array',
            'study_program_ids.*' => 'integer|exists:study_programs,id',
            'website' => ['nullable', 'url', 'max:255', 'regex:/^https?:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}/'],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ], [], [
            'name' => 'nama mitra',
            'business_field' => 'bidang usaha',
            'location' => 'lokasi',
            'type' => 'jenis',
            'study_program_ids' => 'program studi',
        ]);

        // Simpan sebagai integer agar filter JSON (whereJsonContains) konsisten.
        $data['study_program_ids'] = collect($data['study_program_ids'] ?? [])
            ->map(fn ($id) => (int) $id)->unique()->sort()->values()->all();
        $data['is_active'] = $request->boolean('is_active', true);
        unset($data['logo']);

        return $data;
    }

    private function formOptions(): array
    {
        return [
            'studyPrograms' => StudyProgram::orderBy('id')->get(['id', 'name', 'degree']),
            'types' => InternshipPartner::TYPES,
            // Saran isian agar penulisan bidang usaha & lokasi seragam
            'businessFieldSuggestions' => InternshipPartner::distinct()->orderBy('business_field')->pluck('business_field'),
            'locationSuggestions' => InternshipPartner::distinct()->orderBy('location')->pluck('location'),
        ];
    }

    private function deleteLogo(InternshipPartner $partner): void
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }
    }
}
