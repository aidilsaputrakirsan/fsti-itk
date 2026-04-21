<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return $next($request);
        }

        if ($request->is('login*') || $request->is('admin*')) {
            return $next($request);
        }

        $userAgent = $request->userAgent();
        if (preg_match('/bot|crawl|slurp|spider|mediapartners/i', $userAgent)) {
            return $next($request);
        }

        $sessionId = $request->session()->getId();
        $ip = $request->ip();
        $today = Carbon::today()->toDateString();

        $visitor = Visitor::firstOrCreate(
            ['session_id' => $sessionId, 'visit_date' => $today],
            ['ip_address' => $ip, 'hits' => 0]
        );

        $visitor->increment('hits');

        return $next($request);
    }
}
