<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        // Jika belum login, redirect ke login 
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Jika bukan admin, tolak 
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak punya akses ke halaman ini.');
        }

        return $next($request);
    }
}
