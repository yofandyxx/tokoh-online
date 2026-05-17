<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Gunakan Auth Facade 

class EnsureUserIsAdmin
{
    /** 
     * Handle an incoming request. 
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @param  \Closure  $next 
     * @return mixed 
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user login dan role = admin 
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Redirect ke halaman depan dengan pesan error 
            return redirect('/')->with('error', 'Anda tidak memiliki akses.');
        }
        return $next($request);
    }
}