<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureShopAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('gate')->with('info', 'Silakan masuk terlebih dahulu untuk melanjutkan.');
        }

        return $next($request);
    }
}
