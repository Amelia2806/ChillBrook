<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if ($request->age < 18) {
        return redirect()->route('welcome')
            ->withError('Anda berusia kurang dari 18 tahun!');
    }
    Session::flash('succes', 'Anda berusia lebih dari 18 tahun');
    return $next($request);
}
}