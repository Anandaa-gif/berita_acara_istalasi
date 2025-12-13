<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class adminmiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya boleh admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login')->withErrors([
                'email' => 'Anda tidak memiliki akses ke halaman admin.'
            ]);
        }

        return $next($request);
    }
}
