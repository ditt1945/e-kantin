<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'customer') {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Akses ditolak. Anda harus login sebagai customer.');
    }
}
