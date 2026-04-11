<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ZiProfile;
use App\Models\ZiDocument;
use Inertia\Inertia;

class PublicZonaIntegritasController extends Controller
{
    public function index()
    {
        $profile = ZiProfile::first() ?? new ZiProfile();

        $documents = ZiDocument::latest()->get();

        return Inertia::render('Public/ZonaIntegritas/Index', [
            'profile' => $profile,
            'documents' => $documents
        ]);
    }
}