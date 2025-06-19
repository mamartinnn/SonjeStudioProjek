<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Menangani request masuk dan memeriksa apakah user adalah admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */

    // app/Http/Middleware/AdminMiddleware.php
    public function handle($request, Closure $next)
    {
        // Cek apakah user sudah login dan memiliki peran admin
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            // Jika bukan admin, tampilkan error 403 (Forbidden)
            abort(403, 'Forbidden');
        }

        // Lanjutkan ke request berikutnya jika user adalah admin
        return $next($request);
    }
}
