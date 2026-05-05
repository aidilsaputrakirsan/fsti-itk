<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (method_exists($response, 'header')) {
            $response->header('X-Frame-Options', 'SAMEORIGIN');
            $response->header('X-Content-Type-Options', 'nosniff');
            $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

            //   $response->header('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' http://localhost:5173 http://127.0.0.1:5173 http://[::1]:5173; style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://fonts.googleapis.com; img-src 'self' data: https:; font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net; connect-src 'self' ws://localhost:5173 ws://127.0.0.1:5173 ws://[::1]:5173 http://localhost:5173 http://127.0.0.1:5173 http://[::1]:5173;");

            $response->headers->remove('X-Powered-By');
        }

        return $response;
    }
}
