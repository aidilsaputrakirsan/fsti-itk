<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentActivity::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('organizer', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        $years = StudentActivity::selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $activities = $query->orderBy('start_date', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('Admin/StudentActivities/Index', [
            'activities' => $activities,
            'filters' => $request->only(['search', 'year']),
            'availableYears' => $years
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/StudentActivities/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:2000-01-01|before_or_equal:2100-12-31',
            'end_date' => 'nullable|date|after_or_equal:start_date|before_or_equal:2100-12-31',
            'organizer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        StudentActivity::create($validated);

        return redirect()->route('admin.kegiatan-mahasiswa.index')->with('success', 'Kegiatan mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $studentActivity = StudentActivity::findOrFail($id);

        return Inertia::render('Admin/StudentActivities/Edit', [
            'activity' => $studentActivity
        ]);
    }

    public function update(Request $request, $id)
    {
        $studentActivity = StudentActivity::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:2000-01-01|before_or_equal:2100-12-31',
            'end_date' => 'nullable|date|after_or_equal:start_date|before_or_equal:2100-12-31',
            'organizer' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $studentActivity->update($validated);

        return redirect()->route('admin.kegiatan-mahasiswa.index')->with('success', 'Kegiatan mahasiswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $studentActivity = StudentActivity::findOrFail($id);
        $studentActivity->delete();

        return redirect()->route('admin.kegiatan-mahasiswa.index')->with('success', 'Kegiatan mahasiswa berhasil dihapus.');
    }
}