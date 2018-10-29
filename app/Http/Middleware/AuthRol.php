<?php

namespace App\Http\Middleware;

use App\Entity\Usuario;
use Closure;

class AuthRol extends AuthBase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$rol = null)
    {
        $roles = explode('|', $rol);
        if(in_array($this->auth->user()->ID_ROL,$roles)){
            return $next($request);
        }else{
            return redirect()->route(Usuario::redirectRol($this->auth->user()->ID_ROL));
        }
    }
}