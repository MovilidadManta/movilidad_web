<?php

namespace App\Http\Middleware;

use  Session;
use Closure;
use Illuminate\Http\Request;

class CheckIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado
        if (!session::get('usuario')) {
            // Redirige a la página de inicio de sesión
            return redirect()->route('login');
        }

        // Permite que la solicitud continúe
        return $next($request);
    }
}
