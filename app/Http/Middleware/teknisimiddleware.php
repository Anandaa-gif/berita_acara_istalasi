<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class teknisimiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya izinkan user dengan role 'teknisi'
        if (!Auth::check() || Auth::user()->role !== 'teknisi') {
            return redirect('/login')->withErrors(['email' => 'Anda tidak memiliki akses ke halaman ini.']);
        }

        return $next($request);
    }
}
