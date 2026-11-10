<?php

use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\FrameGuard;
use App\Http\Middleware\RateLimit;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(SecurityHeaders::class);
        // $middleware->append(RateLimit::class);
        $middleware->alias([
            'admin' => App\Http\Middleware\UserIsAdmin::class,
            'block.suspicious' => \App\Http\Middleware\BlockSuspiciousIPs::class,
            'revisor' => App\Http\Middleware\UserIsRevisor::class,
            'writer' => App\Http\Middleware\UserIsWriter::class,
            'admin.local' => App\Http\Middleware\OnlyLocalAdmin::class,
        ]);
    })
->withExceptions(function (Exceptions $exceptions) {
    $exceptions->stopIgnoring(AuthorizationException::class);

    $exceptions->report(function (AuthorizationException $e) {
        Log::warning('Tentativo di azione non autorizzata', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'method' => request()->method(),
            'path' => request()->path(),
        ]);
    });
})->create();