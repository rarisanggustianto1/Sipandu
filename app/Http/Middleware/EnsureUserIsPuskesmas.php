<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsPuskesmas
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $isPuskesmas = $user && in_array($user->role, ['tenaga_kesehatan', 'puskesmas'], true);

        if (! $user || ! $isPuskesmas || ! $user->puskesmas_id) {
            abort(403, 'Akses khusus Admin Puskesmas (tenaga kesehatan).');
        }

        return $next($request);
    }
}
