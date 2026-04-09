<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use Inertia\Inertia;

class PublicBeasiswaController extends Controller
{
    public function index()
    {
        $beasiswas = Beasiswa::orderBy('title', 'asc')->get();

        return Inertia::render('Public/Beasiswa/Index', [
            'beasiswas' => $beasiswas
        ]);
    }

}
