<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsDinasKesehatan
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pendaftaran user (misal kader posyandu) hanya dilakukan oleh Dinas Kesehatan.
        if (! auth()->check() || auth()->user()->role !== 'dinas_kesehatan') {
            abort(403, 'Pendaftaran user hanya untuk Dinas Kesehatan.');
        }

        return $next($request);
    }
}
