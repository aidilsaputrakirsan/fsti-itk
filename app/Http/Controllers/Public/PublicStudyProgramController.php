<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use Inertia\Inertia;

class PublicStudyProgramController extends Controller
{
    public function show($slug)
    {
        $studyProgram = StudyProgram::where('slug', $slug)->firstOrFail();

        return Inertia::render('Public/StudyPrograms/Show', [
            'studyProgram' => $studyProgram
        ]);
    }
}