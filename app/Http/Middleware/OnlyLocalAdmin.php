<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class OnlyLocalAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Definisci gli host consentiti, in produzione vanno gli IPs reali o i domini
        $allowedHosts = ['internal.admin:8000'];

        // Recupera l'host dalla richiesta
        $host = $request->header('Host');

        // Verifica se l'host è nell'elenco degli host consentiti
        if (! in_array($host, $allowedHosts)) {
            Log::warning('Unauthorized access attempt to local admin route', [
                'user_id' => auth()->user()?->id,
                'host' => $host,
                'ip' => $request->ip(),
                'route' => $request->path(),
            ]);

            return redirect(route('homepage'))->with('alert', 'Not Authorized');
        }

        return $next($request);
    }
}
