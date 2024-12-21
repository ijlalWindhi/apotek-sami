<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == '1' || Auth::user()->role == '0') {
            return $next($request);
        }

        return redirect()->route('inventory.dashboard');
    }
}
