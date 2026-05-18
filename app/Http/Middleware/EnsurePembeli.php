<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePembeli
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('gate')->with('info', 'Silakan masuk terlebih dahulu.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
