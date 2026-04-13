<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SatisfactionSurvey;
use App\Models\SurveyCategory;
use Inertia\Inertia;

class PublicSatisfactionSurveyController extends Controller
{
    public function index()
    {
        $categories = SurveyCategory::where('is_active', true)->get();

        return Inertia::render('Public/SatisfactionSurveys/Index', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'respondent_name' => 'nullable|string|max:255',
            'respondent_email' => 'nullable|email|max:255',
            'respondent_type' => 'required|string|max:255',
            'service_category' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string',
        ]);

        SatisfactionSurvey::create($validated);

        return redirect()->back()->with('success', 'Terima kasih atas partisipasi Anda!');
    }
}