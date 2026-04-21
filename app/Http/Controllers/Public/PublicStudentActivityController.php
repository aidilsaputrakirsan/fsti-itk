<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StudentActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class PublicStudentActivityController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');

        $activitiesRaw = StudentActivity::orderBy('start_date', 'desc')->get();

        $groupedActivities = $activitiesRaw->groupBy(function ($item) {
            return Carbon::parse($item->start_date)->translatedFormat('F Y');
        });

        return Inertia::render('Public/StudentActivities/Index', [
            'groupedKegiatan' => $groupedActivities 
        ]);
    }
}