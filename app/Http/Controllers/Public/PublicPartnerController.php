<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicPartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        return Inertia::render('Public/Partners/Index', [
            'partners' => $query->orderBy('name', 'asc')->paginate(12)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }
}