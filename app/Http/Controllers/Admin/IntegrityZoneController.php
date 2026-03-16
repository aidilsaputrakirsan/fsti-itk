<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ZiProfile;
use App\Models\ZiDocument;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class IntegrityZoneController extends Controller
{
    // ==========================================
    // BAGIAN 1: KELOLA PROFIL ZI
    // ==========================================
    public function profileEdit()
    {
        // Ambil data pertama, jika belum ada, buatkan data kosong (ID=1)
        $profile = ZiProfile::firstOrCreate(['id' => 1]);

        return Inertia::render('Admin/IntegrityZones/ProfileEdit', [
            'profile' => $profile
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $profile = ZiProfile::firstOrCreate(['id' => 1]);

        $validated = $request->validate([
            'description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'service_declaration_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Maks 5MB untuk maklumat
        ]);

        $profile->description = $validated['description'] ?? $profile->description;
        $profile->user_id = Auth::id();

        // Handle Banner Image
        if ($request->hasFile('banner_image')) {
            if ($profile->banner_image_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $profile->banner_image_path));
            }
            $path = $request->file('banner_image')->store('zi-images', 'public');
            $profile->banner_image_path = '/storage/' . $path;
        }

        // Handle Maklumat Image
        if ($request->hasFile('service_declaration_image')) {
            if ($profile->service_declaration_image_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $profile->service_declaration_image_path));
            }
            $path = $request->file('service_declaration_image')->store('zi-images', 'public');
            $profile->service_declaration_image_path = '/storage/' . $path;
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profil Zona Integritas berhasil diperbarui!');
    }

    // ==========================================
    // BAGIAN 2: KELOLA DOKUMEN ZI
    // ==========================================
    public function documentIndex()
    {
        $documents = ZiDocument::latest()->paginate(10);
        return Inertia::render('Admin/IntegrityZones/DocumentIndex', [
            'documents' => $documents
        ]);
    }

    public function documentStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'file_url' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('zi-documents', 'public');
            $validated['file_url'] = '/storage/' . $path;
        }

        ZiDocument::create($validated);

        return redirect()->back()->with('success', 'Dokumen ZI berhasil ditambahkan!');
    }

    public function documentDestroy($id)
    {
        $document = ZiDocument::findOrFail($id);

        if ($document->file_url && Storage::disk('public')->exists(str_replace('/storage/', '', $document->file_url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $document->file_url));
        }

        $document->delete();

        return redirect()->back()->with('success', 'Dokumen ZI berhasil dihapus!');
    }
}
