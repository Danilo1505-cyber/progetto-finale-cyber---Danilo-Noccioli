<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user() && Auth::user()->is_admin){
            return $next($request);
        }
        Log::warning('Unauthorized access attempt to admin route', [
            'user_id' => Auth::user()?->id,
            'ip' => $request->ip(),
            'route' => $request->path(),
        ]);
        return redirect(route('homepage'))->with('alert', 'Not Authorized');
    }
}
