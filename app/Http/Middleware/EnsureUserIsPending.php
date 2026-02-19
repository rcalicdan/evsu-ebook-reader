<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsPending
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->is_approved) {
            return redirect()->route('dashboard.index');
        }

        return $next($request);
    }
}