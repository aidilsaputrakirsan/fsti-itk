<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SurveyCategoryController extends Controller
{
    public function index()
    {
        $categories = SurveyCategory::latest()->get();
        return Inertia::render('Admin/SatisfactionSurveys/Categories', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        SurveyCategory::create([
            'name' => $request->name,
            'is_active' => true
        ]);
        return back()->with('success', 'Aspek penilaian berhasil ditambahkan!');
    }

    public function update(Request $request, SurveyCategory $surveyCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean'
        ]);
        
        $surveyCategory->update($request->only('name', 'is_active'));
        return back()->with('success', 'Aspek penilaian berhasil diperbarui!');
    }

    public function destroy(SurveyCategory $surveyCategory)
    {
        $surveyCategory->delete();
        return back()->with('success', 'Aspek penilaian berhasil dihapus!');
    }
}