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
        $profile = ZiProfile::first();
        if (!$profile) {
            $profile = (object)[
                'id' => null,
                'description' => '',
                'service_declaration_image_path' => null
            ];
        }

        return Inertia::render('Admin/IntegrityZones/ProfileEdit', [
            'profile' => $profile
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'service_declaration_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', 
        ]);

        $profile = ZiProfile::first();
        if (!$profile) {
            $profile = new ZiProfile();
        }

        $profile->description = $validated['description'];
        $profile->user_id = Auth::id();

        if ($request->hasFile('service_declaration_image')) {
            if ($profile->service_declaration_image_path) {
                $oldPath = str_replace('/storage/', '', $profile->service_declaration_image_path);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
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

        return redirect('/admin/zona-integritas/dokumen')->with('success', 'Dokumen ZI berhasil ditambahkan!');
    }

    public function documentCreate()
    {
        return Inertia::render('Admin/IntegrityZones/DocumentCreate');
    }

    public function documentEdit($id)
    {
        $document = ZiDocument::findOrFail($id);
        return Inertia::render('Admin/IntegrityZones/DocumentEdit', [
            'document' => $document
        ]);
    }

    public function documentUpdate(Request $request, $id)
    {
        $document = ZiDocument::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'file_url' => 'nullable|string',
        ]);

        $document->title = $validated['title'];

        if ($request->hasFile('file')) {
            if ($document->file_url && str_contains($document->file_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $document->file_url));
            }
            $path = $request->file('file')->store('zi-documents', 'public');
            $document->file_url = '/storage/' . $path;
        }
        elseif ($request->filled('file_url') && !$request->hasFile('file')) {
            if ($document->file_url && str_contains($document->file_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $document->file_url));
            }
            $document->file_url = $validated['file_url'];
        }

        $document->save();

        return redirect('/admin/zona-integritas/dokumen')->with('success', 'Dokumen ZI berhasil diperbarui!');
    }

    public function documentDestroy($id)
    {
        $document = ZiDocument::findOrFail($id);

        if ($document->file_url) {
            $filePath = str_replace('/storage/', '', $document->file_url);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        $document->delete();

        return redirect()->back()->with('success', 'Dokumen ZI berhasil dihapus!');
    }
}