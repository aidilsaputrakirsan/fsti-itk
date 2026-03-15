<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PpidDocumentController extends Controller
{
    public function create()
{
    // Mengambil semua kategori untuk pilihan di dropdown form
    $kategoris = \App\Models\KategoriPpid::orderBy('jenis_informasi')->orderBy('urutan')->get();

    return \Inertia\Inertia::render('Admin/Ppid/Create', [
        'kategoris' => $kategoris
    ]);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'kategori_ppid_id' => 'required|exists:kategori_ppids,id',
        'judul_dokumen'    => 'required|string|max:255',
        'file'             => 'nullable|file|mimes:pdf|max:10240', // Maksimal 10MB
        'file_url'         => 'nullable|url',
    ]);

    // Logika simpan file jika ada upload
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('ppid-documents', 'public');
        $validated['file_url'] = '/storage/' . $path;
    }

    \App\Models\DokumenPpid::create($validated);

    return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil ditambahkan!');
}
}
