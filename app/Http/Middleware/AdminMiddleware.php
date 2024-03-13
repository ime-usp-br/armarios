<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole('Admin')) {
            return $next($request);
        }

        abort(403, 'Acesso negado.'); // Ou redirecione para a página de login
    }
}