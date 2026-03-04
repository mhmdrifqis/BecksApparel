<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import Model User

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var User $user */
        $user = Auth::user();

        // Loop setiap role yang diizinkan (misal: admin, pimpinan)
        foreach ($roles as $role) {
            // Panggil fungsi hasRole yang baru kita buat di Model User
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // Jika tidak punya akses, tampilkan error 403 atau redirect
        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk halaman ini.');
    }
}