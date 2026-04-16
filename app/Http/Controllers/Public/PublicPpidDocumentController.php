<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PpidDocument;
use App\Models\PpidCategory;
use App\Models\FacultyProfile; 
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

        $facultyProfile = FacultyProfile::first();
        
        $permohonanLink = $facultyProfile && !empty($facultyProfile->content['ppid_permohonan_link']) 
                            ? $facultyProfile->content['ppid_permohonan_link'] 
                            : 'https://s.itk.ac.id/permintaanformfsti';
                            
        $keberatanLink = $facultyProfile && !empty($facultyProfile->content['ppid_keberatan_link']) 
                            ? $facultyProfile->content['ppid_keberatan_link'] 
                            : 'https://docs.google.com/forms/d/e/1FAIpQLSefIA7eJNmNHt0YXzWaWyLdp4zJUulojXUmh7xlVN-MQxZLlw/viewform';

        return Inertia::render('Public/PpidDocuments/Index', [
            'informationTypes' => $informationTypes,
            'permohonanLink' => $permohonanLink, 
            'keberatanLink' => $keberatanLink   
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