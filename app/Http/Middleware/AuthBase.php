<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard as Guard;
use App\Entity\Usuario;

use Closure;

class AuthBase
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->user()){
            return redirect()->route('login.index');
        }else{
            return $next($request);
        }
    }

    protected function redirectRol(){
        return Usuario::redirectRol();
    }
}