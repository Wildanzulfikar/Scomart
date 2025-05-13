<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user() && auth()->user()->role === 'siswa') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Hanya siswa yang bisa mengakses halaman ini.');
    }
}
