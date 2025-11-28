<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah user adalah ADMIN (Menggunakan helper di Model User)
        // Perhatikan: $request->user() sama dengan auth()->user()
        if ($request->user()->isAdmin()) {
            return $next($request); // Silakan masuk
        }

        // 3. Jika bukan admin, tolak akses (403 Forbidden)
        abort(403, 'Anda tidak memiliki akses ke halaman Administrator.');
    }
}
