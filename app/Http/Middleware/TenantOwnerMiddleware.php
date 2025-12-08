<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TenantOwnerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'tenant_owner') {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Akses ditolak. Anda harus login sebagai tenant owner.');
    }
}
