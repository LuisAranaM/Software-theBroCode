<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Entity\Usuario as Usuario;
use App\Entity\Especialidad as Especialidad;
use App\Entity\Rol as Rol;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller {

    /*public function index() {
       return view('login');
    }

    function logout(Request $request){
        return redirect()->route('login.index');
    }*/

    public function index() {
        if(\Auth::check()){
            return redirect()->route(Usuario::redirectRol(Auth::user()->ID_ROL)); 
        }
        return view('login');
    }

    public function attempt(Request $request,$usuarioGoogle =[]) {
        //dd($usuarioGoogle);
        $usuario = $request->get('usuario', null);
        $pass = $request->get('pass', null);
        if($usuarioGoogle!=NULL){
            //Logueo mediante google 
            //dd("Me estoy logueando mediante Google",$usuarioGoogle);
            $user = Usuario::getCorreo($usuarioGoogle['EMAIL_GOOGLE']);
            if ($user==NULL) {
                //Falta la opción para poder registrarse
                //flash('No existe un usuario en RubriK con ese correo, se debe de crear')->error();
                return redirect()->route('login.google.formulario',['usuarioGoogle' => $usuarioGoogle]);
            }            

            Auth::loginUsingId($user->ID_USUARIO);            
            //Actualizamos la foto de perfil
            Usuario::updateFoto($user->ID_USUARIO,$usuarioGoogle);
        }
        else{

            if (!Auth::attempt(['USUARIO' => $usuario, 'password' => $pass],TRUE)) {
                if (!Auth::attempt(['CORREO' => $usuario, 'password' => $pass],TRUE)) {
                    flash('Usuario o Contraseña errado')->error();
                    return redirect()->route('login.index');
                }
            }        
        }
        //dd(Auth::user());
            return redirect()->route(Usuario::redirectRol(Auth::user()->ID_ROL));
    }

    protected function register($usuario) {
        \App\Models\Usuario::create([
            'NOMBRES' => 'UsuarioPrueba',
            'ID_ROL' => 1,
            'USUARIO' => $usuario,
            'PASS' => Hash::make($usuario),
        ]);
    }

    public function getNetworkUser() {
        $headers = apache_request_headers();
        if (!isset($headers['Authorization'])) {
            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: NTLM');
            exit;
        }
        $auth = $headers['Authorization'];
        if (substr($auth, 0, 5) == 'NTLM ') {
            $msg = base64_decode(substr($auth, 5));
            if (substr($msg, 0, 8) != "NTLMSSP\x00")
                die('error header not recognised');
            if ($msg[8] == "\x01") {
                $msg2 = "NTLMSSP\x00\x02\x00\x00\x00" .
                        "\x00\x00\x00\x00" . // target name len/alloc
                        "\x00\x00\x00\x00" . // target name offset
                        "\x01\x02\x81\x00" . // flags
                        "\x00\x00\x00\x00\x00\x00\x00\x00" . // challenge
                        "\x00\x00\x00\x00\x00\x00\x00\x00" . // context
                        "\x00\x00\x00\x00\x00\x00\x00\x00"; // target info len/alloc/offset
                header('HTTP/1.1 401 Unauthorized');
                header('WWW-Authenticate: NTLM ' . trim(base64_encode($msg2)));
                exit;
            } else if ($msg[8] == "\x03") {
                $user = $this->getstr($msg, 36);
                $domain = $this->getstr($msg, 28);
                $workstation = $this->getstr($msg, 44);
                return strtoupper($user);
            }
        }
    }

    function getstr($msg, $start, $unicode = true) {
        $len = (ord($msg[$start + 1]) * 256) + ord($msg[$start]);
        $off = (ord($msg[$start + 5]) * 256) + ord($msg[$start + 4]);
        if ($unicode)
            return str_replace("\0", '', substr($msg, $off, $len));
        else
            return substr($msg, $off, $len);
    }
    
    function logout(Request $request){
        Auth::logout();
        return redirect()->route('login.index');
    }



       /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('google')->stateless()->user();
        
        $nombreUsuario=$user->getName();
        $emailGoogle=$user->getEmail();
        $imagenPerfil=$user->getAvatar();
        
        $arregloNombre=explode(' ',$nombreUsuario);
        $tamanho=count($arregloNombre);
        $usuarioGoogle=['NOMBRES'=>$arregloNombre[0], 'APELLIDO_PATERNO'=>$arregloNombre[$tamanho-2], 'APELLIDO_MATERNO'=>$arregloNombre[$tamanho-1],
        'EMAIL_GOOGLE'=>$emailGoogle,'IMAGEN_PERFIL'=>$imagenPerfil];

        return self::attempt($request,$usuarioGoogle);

    }

    public function formularioCuentaRubrikGoogle(Request $request){
        
        return view('crear-google')
                ->with('usuarioGoogle',$request->get('usuarioGoogle',null))
                ->with('roles',Rol::getRoles())
                ->with('especialidades',Especialidad::getEspecialidades());

    }


    public function crearCuentaRubrikGoogle(Request $request){
        //dd($request->all());

        //Registraremos el usuario y nos loguearemos
        $usuario=new Usuario();

        if($usuario->crearCuentaRubrik($request->all())){
            //flash('El curso se eliminó con éxito')->success();
            //dd("Nos debemos de loguear");
            $user = Usuario::getCorreo($request->get('email',null));
            Auth::loginUsingId($user->ID_USUARIO);
            return redirect()->route(Usuario::redirectRol(Auth::user()->ID_ROL));

        } else {
            flash('Hubo un error al registrar el usuario')->error();
            return back();
        }
        
        

    }

}
