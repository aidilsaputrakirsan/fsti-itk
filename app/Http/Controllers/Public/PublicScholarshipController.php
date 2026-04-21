<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Inertia\Inertia;

class PublicScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::orderBy('title', 'asc')->get();

        return Inertia::render('Public/Scholarships/Index', [
            'beasiswas' => $scholarships
        ]);
    }
}
