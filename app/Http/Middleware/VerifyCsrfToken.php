<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/iniciar-sesion',
        'orquestador_ordenes/store',
        'orquestador_ordenes/update',
        'session_data/store',
        'session_data/update',
    ];
}
