<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicAnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query();
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return Inertia::render('Public/Pengumuman/Index', [
            'announcements' => $query->latest()->paginate(6)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }
}