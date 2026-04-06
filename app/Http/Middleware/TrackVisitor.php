<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin*') || $request->is('login*')) {
            return $next($request);
        }

        $userAgent = $request->userAgent();
        if (preg_match('/bot|crawl|slurp|spider|mediapartners/i', $userAgent)) {
            return $next($request);
        }

        $ip = $request->ip();
        $today = Carbon::today()->toDateString();

        // Cari atau buat record baru untuk IP ini di hari ini
        $visitor = Visitor::firstOrCreate(
            ['ip_address' => $ip, 'visit_date' => $today],
            ['hits' => 0]
        );

        // Tambah jumlah hit/klik
        $visitor->increment('hits');

        return $next($request);
    }
}
