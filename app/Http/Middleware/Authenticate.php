<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Si la solicitud espera JSON (típico para APIs), devuelve null.
        // Laravel lanzará automáticamente una AuthenticationException,
        // que normalmente se convierte en una respuesta JSON 401.
        return $request->expectsJson() ? null : route('login');
    }
}