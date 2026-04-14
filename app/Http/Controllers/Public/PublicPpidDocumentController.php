<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PpidDocument;
use App\Models\PpidCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PublicPpidDocumentController extends Controller
{
    public function index(Request $request)
    {
        $categories = PpidCategory::with(['dokumen'])->get();

        $informationTypes = $categories->groupBy('jenis_informasi')->map(function ($items, $key) {
            return [
                'type' => $key,
                'slug' => Str::slug($key, '-'),
                'total_categories' => $items->count(),
                'total_documents' => $items->sum(fn($cat) => $cat->dokumen->count()),
            ];
        })->values();

        return Inertia::render('Public/PpidDocuments/Index', [
            'informationTypes' => $informationTypes 
        ]);
    }

    public function show($slug)
    {
        $informationTypeList = PpidCategory::select('jenis_informasi')
            ->distinct()
            ->pluck('jenis_informasi');

        $originalType = null;

        foreach ($informationTypeList as $type) {
            if (Str::slug($type, '-') === $slug) {
                $originalType = $type;
                break;
            }
        }

        if (!$originalType) {
            abort(404);
        }

        $categories = PpidCategory::with(['dokumen' => function($q) {
                $q->orderBy('created_at', 'desc'); 
            }])
            ->where('jenis_informasi', $originalType)
            ->orderBy('urutan', 'asc') 
            ->get();

        return Inertia::render('Public/PpidDocuments/ShowType', [
            'categories' => $categories,
            'information_type' => $originalType
        ]);
    }
}