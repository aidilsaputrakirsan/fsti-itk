<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('organizer', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        $years = Agenda::selectRaw('YEAR(start_date) as year')
            ->distinct()->orderBy('year', 'desc')->pluck('year');

        $agendas = $query->orderBy('start_date', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/Agendas/Index', [
            'agendas' => $agendas,
            'filters' => $request->only(['search', 'year']),
            'availableYears' => $years
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Agendas/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'organizer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Agenda::create($validated);

        return redirect()->route('admin.agenda-fakultas.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return Inertia::render('Admin/Agendas/Edit', ['agenda' => $agenda]);
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'organizer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $agenda->update($validated);

        return redirect()->route('admin.agenda-fakultas.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('admin.agenda-fakultas.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
