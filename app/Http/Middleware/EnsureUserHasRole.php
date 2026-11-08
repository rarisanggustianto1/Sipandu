<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Pemetaan alias role untuk fleksibilitas akses antar-modul.
     */
    public const ROLE_ALIASES = [
        'dinas' => 'dinas_kesehatan',
        'dinas_kesehatan' => 'dinas_kesehatan',
        'puskesmas' => 'tenaga_kesehatan',
        'tenaga_kesehatan' => 'tenaga_kesehatan',
        'kader' => 'kader',
        'kader_posyandu' => 'kader',
        'keluarga' => 'keluarga',
        'peserta' => 'keluarga',
    ];

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $userRole = self::ROLE_ALIASES[$user->role] ?? $user->role;
        $allowedRoles = array_map(fn ($r) => self::ROLE_ALIASES[$r] ?? $r, $roles);

        if (! in_array($userRole, $allowedRoles, true) && ! in_array($user->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
