<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\File;

class PartnerController extends Controller
{
    private $protectedLogos = [
        'bpsdm.png', 'terra-drone.png', 'jasindo.png', 'smk-cendekia.png', 'sma-7.png', 
        'sma-9.png', 'posyantek.png', 'dkumkmp.png', 'universitas-brawijaya.png', 'brida-kaltim.png', 
        'fsad-its.png', 'universitas-kristen.png', 'icdec.png', 'pertamedika.png', 'oikn.png', 
        'universitas-malang.png', 'unesa.png', 'universitas-hasanuddin.png', 'javan.png', 
        'matematika-its.png', 'fteic-its.png', 'astra.png', 'upn.png', 'inixindo.png', 
        'bps.png', 'cqut.png', 'kiet.png'
    ];

    public function index(Request $request)
    {
        $query = Partner::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        return Inertia::render('Admin/Partners/Index', [
            'partners' => $query->latest()->paginate(15)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }

    public function create() { return Inertia::render('Admin/Partners/Create'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'activities_text' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $activities = [];
        if (!empty($validated['activities_text'])) {
            $lines = explode("\n", str_replace("\r", "", $validated['activities_text']));
            foreach ($lines as $line) {
                if (trim($line) !== '') $activities[] = trim($line);
            }
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.]/', '', $file->getClientOriginalName());
            $file->move(public_path('images/mitra'), $filename);
            $logoPath = $filename;
        }

        Partner::create([
            'name' => $validated['name'],
            'activities' => $activities,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Data Kerjasama Mitra berhasil ditambahkan.');
    }

    public function edit(Partner $partner) { return Inertia::render('Admin/Partners/Edit', compact('partner')); }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'activities_text' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $activities = [];
        if (!empty($validated['activities_text'])) {
            $lines = explode("\n", str_replace("\r", "", $validated['activities_text']));
            foreach ($lines as $line) {
                if (trim($line) !== '') $activities[] = trim($line);
            }
        }
        $partner->activities = $activities;
        $partner->name = $validated['name'];

        if ($request->hasFile('logo')) {
            if ($partner->logo && !in_array($partner->logo, $this->protectedLogos)) {
                if (File::exists(public_path('images/mitra/' . $partner->logo))) {
                    File::delete(public_path('images/mitra/' . $partner->logo));
                }
            }

            $file = $request->file('logo');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.]/', '', $file->getClientOriginalName());
            $file->move(public_path('images/mitra'), $filename);
            $partner->logo = $filename;
        }

        $partner->save();
        return redirect()->route('admin.partners.index')->with('success', 'Data Kerjasama Mitra berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo && !in_array($partner->logo, $this->protectedLogos)) {
            if (File::exists(public_path('images/mitra/' . $partner->logo))) {
                File::delete(public_path('images/mitra/' . $partner->logo));
            }
        }
        
        $partner->delete(); 
        return redirect()->route('admin.partners.index')->with('success', 'Data Mitra berhasil dihapus.');
    }
}