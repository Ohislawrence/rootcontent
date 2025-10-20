<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Route;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        // Add URIs here
    ];

    /**
     * Handle the request
     */
    public function handle($request, \Closure $next)
    {
        // Exclude specific route names from CSRF
        $route = $request->route();
        if ($route && in_array($route->getName(), ['payment.callback', 'paystack.callback'])) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
