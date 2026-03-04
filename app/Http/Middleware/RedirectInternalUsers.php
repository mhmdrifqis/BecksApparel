<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // <--- 1. Pastikan import Model User

class RedirectInternalUsers
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // 2. Beritahu kode bahwa variabel $user ini adalah dari class App\Models\User
            /** @var User $user */
            $user = Auth::user();

            // Sekarang dia pasti mengenali method isPelanggan()
            if (! $user->isPelanggan()) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}