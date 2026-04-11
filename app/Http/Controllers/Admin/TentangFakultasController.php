<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TentangFakultas;
use App\Models\Staff;
use App\Models\StudyProgram;
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

        $content = $page->content;

        $countDosen = Staff::where('type', 'Dosen')->where('is_active', true)->count();
        $countTendik = Staff::where('type', 'Tendik')->where('is_active', true)->count();
        $allProdi = StudyProgram::all();
        $s1 = 0;
        $s2 = 0;
        foreach ($allProdi as $p) {
            $name = strtolower($p->name);
            if (str_contains($name, 's2') || str_contains($name, 'magister')) {
                $s2++;
            } else {
                $s1++;
            }
        }

        if (isset($content['statistik']['data'])) {
            foreach ($content['statistik']['data'] as &$stat) {
                $label = strtolower($stat['label']);
                if (str_contains($label, 'dosen')) $stat['angka'] = (string)$countDosen;
                if (str_contains($label, 'tendik') || str_contains($label, 'kependidikan')) $stat['angka'] = (string)$countTendik;
                if (str_contains($label, 's1')) $stat['angka'] = (string)$s1;
                if (str_contains($label, 's2')) $stat['angka'] = (string)$s2;
                if ($label === 'program studi' || $label === 'prodi') $stat['angka'] = (string)$allProdi->count();
            }
        }

        $page->content = $content;

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

        TentangFakultas::updateOrCreate(['id' => 1], ['content' => $content]);

        $pesan = 'Data berhasil diperbarui!';
        return redirect()->back()->with('success', $pesan);
    }
}
