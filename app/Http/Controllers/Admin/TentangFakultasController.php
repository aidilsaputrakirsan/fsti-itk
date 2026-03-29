<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TentangFakultasController extends Controller
{
    public function edit()
    {
        $page = StaticPage::firstOrCreate(
            ['key' => 'tentang_fakultas'],
            [
                'title' => 'Tentang Fakultas',
                'content' => [
                    'statistik' => ['deskripsi' => '', 'data' => []],
                    'tugas_fungsi' => ['tugas' => '', 'dasar_tugas' => '', 'fungsi' => [], 'dasar_fungsi' => ''],
                    'visi_misi' => ['visi' => '', 'misi_tagline' => '', 'misi' => []]
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
            'content' => 'required|array'
        ]);

        StaticPage::where('key', 'tentang_fakultas')->update([
            'content' => $request->content
        ]);

        return redirect()->back()->with('success', 'Data Tentang Fakultas berhasil diperbarui!');
    }
}