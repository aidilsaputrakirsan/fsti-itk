<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpidDocument;
use App\Models\PpidCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class PpidDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = PpidDocument::with('kategori');

        if ($request->filled('search')) {
            $query->where('judul_dokumen', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jenis')) {
            $jenis = $request->jenis;
            $query->whereHas('kategori', function ($q) use ($jenis) {
                $q->where('jenis_informasi', $jenis);
            });
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        $documentTypes = PpidCategory::select('jenis_informasi')
            ->distinct()
            ->pluck('jenis_informasi');

        return Inertia::render('Admin/PpidDocuments/Index', [
            'documents' => $documents,
            'filters' => $request->only(['search', 'jenis']),
            'documentTypes' => $documentTypes,
        ]);
    }

    public function create()
    {
        $categories = PpidCategory::orderBy('jenis_informasi')->orderBy('urutan')->get();

        return Inertia::render('Admin/PpidDocuments/Create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_ppid_id' => 'required|exists:ppid_categories,id',
            'judul_dokumen'    => 'required|string|max:255',
            'file'             => 'nullable|file|mimes:pdf|max:10240',
            'file_url'         => 'nullable|string',
        ]);

        $dataToSave = [
            'ppid_category_id' => $validated['kategori_ppid_id'],
            'judul_dokumen'    => $validated['judul_dokumen'],
            'file_url'         => $validated['file_url'] ?? null,
        ];

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('ppid-documents', 'public');
            $dataToSave['file_url'] = '/storage/' . $path;
        }

        PpidDocument::create($dataToSave);

        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $document = PpidDocument::findOrFail($id);
        $categories = PpidCategory::orderBy('jenis_informasi')->orderBy('urutan')->get();

        return Inertia::render('Admin/PpidDocuments/Edit', [
            'document' => $document,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, string $id)
    {
        $document = PpidDocument::findOrFail($id);

        $validated = $request->validate([
            'kategori_ppid_id' => 'required|exists:ppid_categories,id',
            'judul_dokumen'    => 'required|string|max:255',
            'file'             => 'nullable|file|mimes:pdf|max:10240',
            'file_url'         => 'nullable|string',
        ]);

        $dataToUpdate = [
            'ppid_category_id' => $validated['kategori_ppid_id'],
            'judul_dokumen'    => $validated['judul_dokumen'],
            'file_url'         => array_key_exists('file_url', $validated) ? $validated['file_url'] : $document->file_url,
        ];

        if ($request->hasFile('file')) {
            if ($document->file_url && Storage::disk('public')->exists(str_replace('/storage/', '', $document->file_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $document->file_url));
            }
            $path = $request->file('file')->store('ppid-documents', 'public');
            $dataToUpdate['file_url'] = '/storage/' . $path;
        }

        $document->update($dataToUpdate);

        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $document = PpidDocument::findOrFail($id);

        if ($document->file_url && Storage::disk('public')->exists(str_replace('/storage/', '', $document->file_url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $document->file_url));
        }

        $document->delete();

        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil dihapus!');
    }
}
