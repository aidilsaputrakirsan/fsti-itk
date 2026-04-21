<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class PublicAgendaController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');
        
        $agendas = Agenda::orderBy('start_date', 'desc')->get()->groupBy(function ($item) {
            return Carbon::parse($item->start_date)->translatedFormat('F Y');
        });

        return Inertia::render('Public/Agendas/Index', [
            'groupedAgendas' => $agendas
        ]);
    }
}