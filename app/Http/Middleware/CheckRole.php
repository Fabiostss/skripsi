<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  Role yang diizinkan untuk mengakses route.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        
       // Periksa apakah user sudah login dan role_name-nya sesuai dengan yang diizinkan.
        if (!Auth::check() || Auth::user()->role_name !== $role) {
            // Jika tidak, alihkan pengguna ke halaman login.
            return redirect('/Error');
        }

        // Jika sesuai, lanjutkan request.
        return $next($request);
    }
}
