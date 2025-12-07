<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) return redirect()->route('login')->withErrors('Please login first.');
        if (!Auth::user()->isRole($roles)) return abort(403, 'Unauthorized');
        return $next($request);
    }
}
