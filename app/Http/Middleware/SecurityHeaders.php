<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'no-referrer');
        $response->headers->set('Content-Security-Policy',
            "default-src 'self'; ".
            "script-src 'self' http://127.0.0.1:5173 http://localhost:5173; ".
            "style-src 'self' http://127.0.0.1:5173 http://localhost:5173 'unsafe-inline'; ".
            "img-src 'self' data:; ".
            "font-src 'self'; ".
            "connect-src 'self' http://127.0.0.1:5173 ws://127.0.0.1:5173 ws://localhost:5173; ".
            "frame-src 'none'; ".
            "object-src 'none'; ".
            "base-uri 'self'; ".
            "form-action 'self';"
        );

        return $response;
    }
}