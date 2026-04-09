<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use Inertia\Inertia;

class PublicProgramStudiController extends Controller
{
    /**
     * Menampilkan halaman detail Program Studi berdasarkan slug
     */
    public function show($slug)
    {
        $prodi = StudyProgram::where('slug', $slug)->firstOrFail();

        return Inertia::render('Public/ProgramStudi/Show', [
            'prodi' => $prodi
        ]);
    }
}
