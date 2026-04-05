<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penelitian;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PenelitianController extends Controller
{
    public function index(Request $request)
    {
        $query = Penelitian::query();

        if ($request->search) {
            $query->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('nama_dosen', 'like', "%{$request->search}%");
        }

        $penelitians = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Penelitian/Index', [
            'penelitians' => $penelitians,
            'filters' => $request->only(['search'])
        ]);
    }

    public function destroy(Penelitian $penelitian)
    {
        $penelitian->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}