<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenPpid;
use App\Models\KategoriPpid; // Tambahkan import ini
use Inertia\Inertia;

class PpidController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenPpid::with('kategori');

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where('judul_dokumen', 'like', '%' . $request->search . '%');
        }

        // Filter Jenis Informasi
        if ($request->filled('jenis')) {
            $jenis = $request->jenis;
            $query->whereHas('kategori', function ($q) use ($jenis) {
                $q->where('jenis_informasi', $jenis);
            });
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        // AMBIL JENIS INFORMASI SECARA DINAMIS
        $listJenis = KategoriPpid::select('jenis_informasi')
            ->distinct()
            ->pluck('jenis_informasi');

        return Inertia::render('Admin/Ppid/Index', [
            'documents' => $documents,
            'filters' => $request->only(['search', 'jenis']),
            'listJenis' => $listJenis, // Kirim ke Vue
        ]);
    }
    public function create()
    {
        // Mengambil semua kategori agar muncul di dropdown pilihan form
        $kategoris = KategoriPpid::orderBy('jenis_informasi')->orderBy('urutan')->get();

        return Inertia::render('Admin/Ppid/Create', [
            'kategoris' => $kategoris
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_ppid_id' => 'required|exists:kategori_ppids,id',
            'judul_dokumen'    => 'required|string|max:255',
            'file'             => 'nullable|file|mimes:pdf|max:10240',
            'file_url'         => 'nullable|string', // Diubah jadi string agar bisa menerima slug/path internal
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('ppid-documents', 'public');
            $validated['file_url'] = '/storage/' . $path;
        }

        \App\Models\DokumenPpid::create($validated);

        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil ditambahkan!');
    }
    public function edit(string $id)
    {
        $document = DokumenPpid::findOrFail($id);
        $kategoris = KategoriPpid::orderBy('jenis_informasi')->orderBy('urutan')->get();

        return Inertia::render('Admin/Ppid/Edit', [
            'document' => $document,
            'kategoris' => $kategoris
        ]);
    }

    public function update(Request $request, string $id)
    {
        $document = DokumenPpid::findOrFail($id);

        $validated = $request->validate([
            'kategori_ppid_id' => 'required|exists:kategori_ppids,id',
            'judul_dokumen'    => 'required|string|max:255',
            'file'             => 'nullable|file|mimes:pdf|max:10240',
            'file_url'         => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($document->file_url && \Storage::disk('public')->exists(str_replace('/storage/', '', $document->file_url))) {
                \Storage::disk('public')->delete(str_replace('/storage/', '', $document->file_url));
            }
            $path = $request->file('file')->store('ppid-documents', 'public');
            $validated['file_url'] = '/storage/' . $path;
        }

        $document->update($validated);

        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $document = DokumenPpid::findOrFail($id);

        if ($document->file_url && \Storage::disk('public')->exists(str_replace('/storage/', '', $document->file_url))) {
            \Storage::disk('public')->delete(str_replace('/storage/', '', $document->file_url));
        }

        $document->delete();

        return redirect()->route('admin.ppid.index')->with('success', 'Dokumen berhasil dihapus!');
    }
}
