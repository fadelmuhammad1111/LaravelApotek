<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class isKasir
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role === 'kasir'){
            return $next($request);
    } else {
        return redirect()->route('home.page')->with('failed', 'anda (admin) tidak memiliki akses!');
        }
    }
}
