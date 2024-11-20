<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Role 0 = admin, Role 1 = kasir
                if ($user->role == '0') {
                    return redirect()->route('inventory.dashboard');
                }
                return redirect()->route('pos.index');
            }
        }

        return $next($request);
    }
}
