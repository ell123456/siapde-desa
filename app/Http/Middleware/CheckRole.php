<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika user sudah login DAN role-nya ada di daftar yang diizinkan
        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            return $next($request); // Boleh lewat
        }

        // Jika tidak punya izin, tendang balik ke dashboard dengan pesan error
        return redirect()->route('dashboard')->with('error', 'Akses Ditolak! Anda tidak punya izin masuk ke sini.');
    }
}
