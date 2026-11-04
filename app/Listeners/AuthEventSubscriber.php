<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

class AuthEventSubscriber
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handleUserLogin(Login $event): void
    {
        $user = $event->user;

        Log::info('User logged in', [
            'user_id' => $user->id,
            'ip' => request()->ip(),
        ]);

    }

    public function handleUserLogout(Logout $event): void
    {

        Log::info('User logged out', [
            'user_id' => $event->user?->id,
            'ip' => request()->ip(),
        ]);
    }

    public function handleUserLoginFailed(Failed $event): void
    {
        Log::warning('User login failed', [
            'email' => $event->credentials['email'] ?? null,
            'ip' => request()->ip(),
        ]);
    }

    public function handleUserLockout(Lockout $event): void
    {
        Log::error('User lockout: too many failed login attempts', [
            'email' => $event->request->input('email'),
            'ip' => $event->request->ip(),
        ]);
    }

    public function handleUserRegistered(Registered $event): void 
    {
        Log::info('User registered', [
            'user_id' => $event->user->id,
            'ip' => request()->ip(),
        ]);
    }
}
