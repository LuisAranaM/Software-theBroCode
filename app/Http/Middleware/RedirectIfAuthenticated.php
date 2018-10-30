<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Entity\Usuario;

class RedirectIfAuthenticated extends AuthBase {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        if (Auth::guard($guard)->check()) {
            if (Auth::User()->ROL == 1) {
                return redirect(Usuario::redirectRol());
            }

            return $next($request);
        }
    }

}
