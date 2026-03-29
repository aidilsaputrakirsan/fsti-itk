<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TentangFakultas; 
use Illuminate\Http\Request;
use Inertia\Inertia;

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

        TentangFakultas::updateOrCreate(
            ['id' => 1],
            ['content' => $request->content]
        );

        return redirect()->back()->with('success', 'Data Tentang Fakultas berhasil diperbarui!');
    }
}