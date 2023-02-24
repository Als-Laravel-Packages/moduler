<?php

namespace Aldev\Moduler\Http\Middleware;

use Closure;

/**
 * The ModulerMiddleware class.
 *
 * @package aldev/moduler
 * @author  Al Lestaire Acasio <allestaire.acasio@gmail.com>
 */
class ModulerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Illuminate\Http\Request $request
     * @param  Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
