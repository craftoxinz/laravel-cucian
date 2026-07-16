<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        // Ambil nama role user (misal: 'admin', 'kasir', atau 'kurir')
        $userRole = auth()->user()->role->name;

        // Pecah parameter jika dipisahkan dengan koma (misal: "admin,kasir" menjadi ['admin', 'kasir'])
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode(',', $role));
        }

        // Jika role user tidak ada di daftar role yang dizinkan, tolak akses
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}