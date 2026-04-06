<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Visitor;
use Carbon\Carbon;
// ------------------------------

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'globalProdi' => \App\Models\StudyProgram::select('name', 'degree', 'slug', 'department')
                ->orderBy('degree')
                ->orderBy('name')
                ->get(),

            'visitorStats' => fn() => $request->is('admin*') ? null : [
                'today' => Visitor::where('visit_date', Carbon::today()->toDateString())->count(),
                'month' => Visitor::where('visit_date', '>=', Carbon::now()->startOfMonth()->toDateString())->count(),
                'total' => Visitor::count(),
            ],
            // --------------------------
        ];
    }
}
