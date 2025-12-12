<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SatisfactionSurveyController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\SatisfactionSurvey::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('respondent_name', 'like', '%' . $request->search . '%')
                  ->orWhere('respondent_email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('respondent_type')) {
            $query->where('respondent_type', $request->respondent_type);
        }

        $surveys = $query->latest()->paginate(10)->withQueryString();

        return \Inertia\Inertia::render('Admin/SatisfactionSurveys/Index', [
            'surveys' => $surveys,
            'filters' => $request->only(['search', 'respondent_type']),
        ]);
    }

    public function create()
    {
        // Not needed - data comes from public form
    }

    public function store(Request $request)
    {
        // Not needed - data comes from public form
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        // Not needed - read-only
    }

    public function update(Request $request, string $id)
    {
        // Not needed - read-only
    }

    public function destroy(string $id)
    {
        $survey = \App\Models\SatisfactionSurvey::findOrFail($id);
        $survey->delete();

        return redirect()->route('admin.satisfaction-surveys.index')->with('success', 'Survei berhasil dihapus!');
    }
}
