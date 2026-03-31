<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TentangFakultas; 
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class TentangFakultasController extends Controller
{
    public function edit()
    {
        $page = TentangFakultas::firstOrCreate(
            ['id' => 1],
            [
                'content' => [
                    'statistik' => ['deskripsi' => '', 'data' => []],
                    'tugas_fungsi' => ['tugas' => '', 'fungsi' => []],
                    'visi_misi' => ['visi' => '', 'misi_tagline' => '', 'misi' => []],
                    'bagan_organisasi' => 'images/bagan-organisasi.webp'
                ]
            ]
        );

        return Inertia::render('Admin/Profil/Tentang', [
            'tentang' => $page
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|array',
            'bagan_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $tentang = TentangFakultas::first();
        $content = $request->content;

        // LOGIKA UPLOAD GAMBAR BAGAN
        if ($request->hasFile('bagan_image')) {
            if (isset($tentang->content['bagan_organisasi']) && !str_starts_with($tentang->content['bagan_organisasi'], 'images/')) {
                Storage::disk('public')->delete($tentang->content['bagan_organisasi']);
            }
            $path = $request->file('bagan_image')->store('tentang', 'public');
            $content['bagan_organisasi'] = $path;
        } else {
            if ($tentang && isset($tentang->content['bagan_organisasi'])) {
                $content['bagan_organisasi'] = $tentang->content['bagan_organisasi'];
            }
        }

        TentangFakultas::updateOrCreate(
            ['id' => 1],
            ['content' => $content]
        );

        $pesan = 'Data Tentang Fakultas berhasil diperbarui!';
        if ($request->active_tab === 'statistik') {
            $pesan = 'Data Statistik Fakultas berhasil diperbarui!';
        } elseif ($request->active_tab === 'tugas') {
            $pesan = 'Data Tugas & Fungsi berhasil diperbarui!';
        } elseif ($request->active_tab === 'visi') {
            $pesan = 'Data Visi & Misi berhasil diperbarui!';
        } elseif ($request->active_tab === 'bagan') {
            $pesan = 'Gambar Bagan Organisasi berhasil diperbarui!';
        }

        return redirect()->back()->with('success', $pesan);
    }
}