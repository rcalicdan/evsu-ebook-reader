<?php

namespace App\Http\Middleware;

use App\Services\RedirectNotification;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsNotSuspended
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->is_suspended) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            RedirectNotification::error('Your account has been suspended. Please contact an administrator.');

            return redirect()->route('login');
        }

        return $next($request);
    }
}