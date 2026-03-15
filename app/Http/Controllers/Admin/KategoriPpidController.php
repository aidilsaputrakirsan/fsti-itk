<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriPpid;
use Inertia\Inertia;

class KategoriPpidController extends Controller
{
    public function index()
    {
        $kategoris = KategoriPpid::orderBy('urutan', 'asc')->get();
        return Inertia::render('Admin/KategoriPpid/Index', [
            'kategoris' => $kategoris
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/KategoriPpid/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_informasi' => 'required|string|max:255',
            'nama_kategori' => 'required|string|max:255',
            'urutan' => 'nullable|integer',
        ]);

        KategoriPpid::create($request->all());

        return redirect()->route('admin.kategori-ppid.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $kategori = KategoriPpid::findOrFail($id);
        return Inertia::render('Admin/KategoriPpid/Edit', [
            'kategori' => $kategori
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis_informasi' => 'required|string|max:255',
            'nama_kategori' => 'required|string|max:255',
            'urutan' => 'nullable|integer',
        ]);

        $kategori = KategoriPpid::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('admin.kategori-ppid.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        KategoriPpid::findOrFail($id)->delete();
        return redirect()->route('admin.kategori-ppid.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
