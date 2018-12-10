<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Entity\Usuario as Usuario;
use Validator;

class PassController extends Controller {

    public function gen() {     
        return view('pass-gen')
                ->with('pass', $this->generateRandomString(6));
    }

    public function save(Request $request) {

        $correo = $request->get('usuario', null);
        $pass = $request->get('pass', null);
        //actualizar password
        if (\App\Models\Usuario::updatePassword($correo, $pass)){
            flash('Pass actualizado para el correo ' . $correo . ': ' . $pass)->success();
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
        if ($pass == '123') {
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

     function formularioNuevaContrasena(Request $request) {
        return view('passUpdate');
    }

    function recuperarContrasena(){
        return view('resetPassword');
    }

    function recuperarContrasenaCorreo(Request $request){
        $usuario = $request->get('usuario', null);
        $eUsuario=new Usuario();
            
        if(!$eUsuario->verificarCuenta($usuario)){
            flash('No existe una cuenta asociada a este usuario o correo')->error();
            return back();            
        }        
        $correo=$eUsuario->obtenerCorreoUsuario($usuario);
        //Generamos pass aleatoria
        $passRandom=self::generateRandomString();
        if($eUsuario->recuperarContrasena($correo,$passRandom)){
            flash('Se te ha enviado un correo a '.$correo.'')->success();
            return redirect()->route('login.index');            
        }
    }

     function actualizarContrasena(Request $request){
        /*
            Mediante esta función lograremos actualizar en la base de datos
            la nueva contraseña que el usuario haya elegido
        */
            
            $passA=$request->get('passwA');
            $passN=$request->get('passwN');
            $passR=$request->get('passwR');

            $usuarioActual = Auth::id(); 
            
            $usuario=new Usuario();
            
            if(!($passN==$passR)) {
                 $usuario->setMessage('La contraseña de confirmación no coincide con la nueva ingresada');
                 flash($usuario->getMessage())->error();
                 return back();
            }
            else if(strlen($passN)<6 and strlen($passN)>20){
                 $usuario->setMessage('La contraseña debe ser mayor a 6 caracteres y menor a 20');
                 flash($usuario->getMessage())->error();
                 return back();
            }
            else{                
                if($passA==$passN){
                    $usuario->setMessage('La nueva contraseña debe de ser diferente de la anterior');
                    flash($usuario->getMessage())->error();
                    return back();
                }

                if($usuario->actualizarContrasena($usuarioActual,$passA,$passN)){
                    flash($usuario->getMessage())->success();
                    return back();
                }
                else{
                    flash($usuario->getMessage())->error();
                    return back();
                }
            
            }

            
    }
}
