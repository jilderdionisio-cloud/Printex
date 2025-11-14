<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no hay usuario autenticado → mandar al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Si el usuario NO es admin → redirigir al home con mensaje
        if (Auth::user()->role !== 'admin') {
            return redirect()
                ->route('home')
                ->with('error', 'No tienes permiso para acceder al panel de administración.');
        }

        // Si es admin → continuar
        return $next($request);
    }
}
