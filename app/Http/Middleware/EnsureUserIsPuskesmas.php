<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsPuskesmas
{
    public function handle(Request $request, Closure $next): Response
    {
        // Admin Puskesmas dikenali dari role 'tenaga_kesehatan'
        // yang terdaftar pada puskesmas tertentu (puskesmas_id terisi).
        $user = auth()->user();

        if (! auth()->check() || $user->role !== 'tenaga_kesehatan' || ! $user->puskesmas_id) {
            abort(403, 'Akses khusus Admin Puskesmas (tenaga kesehatan).');
        }

        return $next($request);
    }
}
