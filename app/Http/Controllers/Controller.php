<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
<<<<<<< HEAD
=======
use Illuminate\Contracts\Auth\Guard as Guard;
use App\Entity\Usuario as Usuario;
use Illuminate\Support\Facades\Auth;
>>>>>>> AranaBranch

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
<<<<<<< HEAD
=======

    protected $user;
    protected $auth;

    public function __construct(Guard $auth)
    {	
        if ($auth->user()){
        	$usuario = new Usuario();
    		$usuario->setFromAuth($auth->user());
        	$this->user = $usuario;	
        }
    }
>>>>>>> AranaBranch
}
