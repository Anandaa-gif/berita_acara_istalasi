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
        if (Auth::user()->role !== 'teknisi') {
            return redirect()->route('dashboard.index');
        }

        // Role admin → lanjut
        return $next($request);
    }
}
