<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Periksa apakah pengguna adalah admin
        if (auth()->user()->level != 'admin') {
            // Alihkan ke halaman khusus non-admin
            return response()->view('admin.user'); // View untuk non-admin
        }

        // Lanjutkan ke request berikutnya jika pengguna adalah admin
        return $next($request);
    }
}
