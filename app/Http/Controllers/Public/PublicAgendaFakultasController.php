<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AgendaFakultas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class PublicAgendaFakultasController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');
        $agendas = AgendaFakultas::orderBy('start_date', 'desc')->get()->groupBy(function($item) {
            return Carbon::parse($item->start_date)->translatedFormat('F Y'); 
        });

        return Inertia::render('Public/Agenda/Index', [
            'groupedAgendas' => $agendas
        ]);
    }
}