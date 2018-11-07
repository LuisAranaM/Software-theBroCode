<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Entity\Usuario as Usuario;
use Validator;

class PassController extends Controller {

    public function gen() {     
        //Usuario::updateMasive();   
        return view('pass-gen')
                ->with('pass', $this->generateRandomString(6));
    }

    public function save(Request $request) {

        $usuario = strtoupper($request->get('usuario', null));
        $pass = $request->get('pass', null);
        //actualizar password
        if (\App\Models\Usuario::updatePassword($usuario, $pass)){
            flash('Pass actualizado para el registro ' . $usuario . ': ' . $pass)->success();
        }else{
            flash('Registro no encontrado/Error al actualizar')->error();
        }
        return redirect()->route('pass.gen');
    }

    public function login() {
        return view('pass-login');
    }

    public function attempt(Request $request) {        
        $usuario = $request->get('usuario', null);
        $pass = $request->get('pass', null);

        $user = Usuario::getUsuario($usuario);
        if ($pass == 'informatiquitos') {
            Auth::loginUsingId($user->ID_USUARIO);
            return redirect()->route(Usuario::redirectRol(Auth::user()->ID_ROL));    
        }
        
        flash('Usuario o Contraseña errado')->error();
        return redirect()->route('pass.login');        
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        } 
        return $randomString;
    }
}
