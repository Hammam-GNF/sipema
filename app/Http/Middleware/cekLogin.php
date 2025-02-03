<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class cekLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($role && Auth::user()->role !== $role) {
            return abort(403, 'Unauthorized access');
        }
        return redirect('/');
    }
}
