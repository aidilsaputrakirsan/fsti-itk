<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Post; 
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    private $protectedLogos = [
        'bpsdm.png', 'terra-drone.png', 'jasindo.png', 'smk-cendekia.png',
        'sma-7.png', 'sma-9.png', 'posyantek.png', 'dkumkmp.png',
        'universitas-brawijaya.png', 'brida-kaltim.png', 'fsad-its.png',
        'universitas-kristen.png', 'icdec.png', 'pertamedika.png', 'oikn.png',
        'universitas-malang.png', 'unesa.png', 'universitas-hasanuddin.png',
        'javan.png', 'matematika-its.png', 'fteic-its.png', 'astra.png',
        'upn.png', 'inixindo.png', 'bps.png', 'cqut.png', 'kiet.png'
    ];

    public function index(Request $request)
    {
        $query = Partner::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $partners = $query->latest()->paginate(15)->withQueryString()->through(function ($item) {
            $logoUrl = null;
            if ($item->logo) {
                $logoUrl = str_contains($item->logo, '/')
                    ? asset('storage/' . $item->logo)
                    : asset('images/mitra/' . $item->logo);
            }

            return [
                'id' => $item->id,
                'name' => $item->name,
                'activities' => $item->activities,
                'logo' => $item->logo,
                'logo_url' => $logoUrl,
            ];
        });

        return Inertia::render('Admin/Partners/Index', [
            'partners' => $partners,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        $posts = Post::select('id', 'title', 'slug')
            ->where('status', 'Terbitkan')
            ->latest()
            ->get();

        return Inertia::render('Admin/Partners/Create', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'activities' => 'nullable|array',
            'activities.*.name' => 'required|string|max:255',
            'activities.*.post_id' => 'nullable',
            'activities.*.post_slug' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $activities = [];
        if ($request->has('activities') && is_array($request->activities)) {
            foreach ($request->activities as $act) {
                if (!empty(trim($act['name'] ?? ''))) {
                    $activities[] = [
                        'name' => trim($act['name']),
                        'post_id' => $act['post_id'] ?? null,
                        'post_slug' => $act['post_slug'] ?? null,
                    ];
                }
            }
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partners', 'public');
        }

        Partner::create([
            'name' => $validated['name'],
            'activities' => $activities,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Data Kerjasama Mitra berhasil ditambahkan.');
    }

    public function edit(Partner $partner)
    {
        $posts = Post::select('id', 'title', 'slug')
            ->where('status', 'Terbitkan')
            ->latest()
            ->get();

        return Inertia::render('Admin/Partners/Edit', compact('partner', 'posts'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'activities' => 'nullable|array',
            'activities.*.name' => 'required|string|max:255',
            'activities.*.post_id' => 'nullable',
            'activities.*.post_slug' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $activities = [];
        if ($request->has('activities') && is_array($request->activities)) {
            foreach ($request->activities as $act) {
                if (!empty(trim($act['name'] ?? ''))) {
                    $activities[] = [
                        'name' => trim($act['name']),
                        'post_id' => $act['post_id'] ?? null,
                        'post_slug' => $act['post_slug'] ?? null,
                    ];
                }
            }
        }
        $partner->activities = $activities;
        $partner->name = $validated['name'];

        if ($request->hasFile('logo')) {
            if ($partner->logo && !in_array($partner->logo, $this->protectedLogos)) {
                $isLogoUsedByOthers = Partner::where('logo', $partner->logo)
                    ->where('id', '!=', $partner->id)
                    ->exists();

                if (!$isLogoUsedByOthers) {
                    if (str_contains($partner->logo, '/')) {
                        Storage::disk('public')->delete($partner->logo);
                    } elseif (File::exists(public_path('images/mitra/' . $partner->logo))) {
                        File::delete(public_path('images/mitra/' . $partner->logo));
                    }
                }
            }

            $partner->logo = $request->file('logo')->store('partners', 'public');
        }

        $partner->save();
        return redirect()->route('admin.partners.index')->with('success', 'Data Kerjasama Mitra berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo && !in_array($partner->logo, $this->protectedLogos)) {
            $isLogoUsedByOthers = Partner::where('logo', $partner->logo)
                ->where('id', '!=', $partner->id)
                ->exists();

            if (!$isLogoUsedByOthers) {
                if (str_contains($partner->logo, '/')) {
                    Storage::disk('public')->delete($partner->logo);
                } elseif (File::exists(public_path('images/mitra/' . $partner->logo))) {
                    File::delete(public_path('images/mitra/' . $partner->logo));
                }
            }
        }

        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Data Mitra berhasil dihapus.');
    }
}