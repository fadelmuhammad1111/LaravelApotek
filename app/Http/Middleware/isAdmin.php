<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }

        return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    
}
