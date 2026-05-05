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

        $partners = $query->orderBy('id', 'asc')->paginate(12)->withQueryString()->through(function ($item) {
            $logoUrl = null;
            if ($item->logo) {
                $logoUrl = str_contains($item->logo, '/')
                    ? asset('storage/' . $item->logo)
                    : asset('images/mitra/' . $item->logo);
            }

            return [
                'id' => $item->id,
                'name' => $item->name,
                'activities' => $item->activities,
                'logo_url' => $logoUrl,
            ];
        });

        return Inertia::render('Public/Partners/Index', [
            'partners' => $partners,
            'filters' => $request->only(['search'])
        ]);
    }
}
