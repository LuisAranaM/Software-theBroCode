<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Usuario as Usuario;
use App\Entity\Rol as Rol;
use App\Entity\Especialidad as Especialidad;
use App\Entity\Semestre as Semestre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function gestionUsuarios(Request $request){
        //dd("HOLI");
        $filtros=[
            'page' => $request->get('page',1),
            'estado' => $request->get('estado',1),
            'rol' => $request->get('rolBuscar',null),
            'especialidad' => $request->get('especialidadBuscar',null),
            'usuario' => $request->get('usuarioBuscar',null),
            'email' => $request->get('emailBuscar',null),
            'nombres' => $request->get('nombreBuscar',null),
        ];
        //dd($filtros);
        $orden=[];
        return view('administrador.gestion-usuario')
        ->with('usuarios',Usuario::getUsuariosGestion($filtros,$orden)->setPath(config('app.url').'admin/gestionar-usuario'))
        ->with('filtros',$filtros)
        ->with('orden',$orden)
        ->with('roles',Rol::getRoles())
        ->with('especialidades',Especialidad::getEspecialidades());
    } 

    public function activacionUsuarios(Request $request){
        $filtros=[
            'page' => $request->get('page',1),
            'estado' => $request->get('estado',0),
             'rol' => $request->get('rolBuscar',null),
            'especialidad' => $request->get('especialidadBuscar',null),
            'usuario' => $request->get('usuarioBuscar',null),
            'email' => $request->get('emailBuscar',null),
            'nombres' => $request->get('nombreBuscar',null),
        ];

        $orden=[];
        return view('administrador.activacion-usuario')
        ->with('usuarios',Usuario::getUsuariosGestion($filtros,$orden)->setPath(config('app.url').'admin/gestionar-usuario'))
        ->with('filtros',$filtros)
        ->with('orden',$orden)
        ->with('roles',Rol::getRoles())
        ->with('especialidades',Especialidad::getEspecialidades());
    }


    public function activarUsuarios(Request $request){

        $usuario=new Usuario();
        $checks=$request->get('checkActivar',null);

        if (!$checks)
            return back();
        if($usuario->activarUsuarios($checks,Auth::id())){
            flash('Se activaron los usuarios correctamente')->success();
            //return back();
        } else {
            flash($usuario->getMessage())->error();
        }
        return back();
    }

    public function crearCuentaRubrik(Request $request){
        //dd($request->all());


        $usuario=new Usuario();

        if($usuario->crearCuentaRubrik($request->all())){
            flash('Se registró el usuario correctamente')->success();
            //return back();
        } else {
            flash($usuario->getMessage())->error();
        }
        return back();      
        

    }


    public function editarCuentaRubrik(Request $request){
        //dd($request->all());
        //En construcción
        $usuario=new Usuario();

        if($usuario->editarCuentaRubrik($request->all())){
            flash('Se editó el usuario correctamente')->success();
            //return back();
        } else {
            flash($usuario->getMessage())->error();
        }
        return back();      
        

    }


    public function eliminarCuentaRubrik(Request $request){
        //dd($request->all());
        //En construcción
        $usuario=new Usuario();

        if($usuario->eliminarCuentaRubrik($request->get('idUsuario'),Auth::id())){
            flash('Se eliminó el usuario correctamente')->success();
            //return back();
        } else {
            flash($usuario->getMessage())->error();
        }
        return back();      
        

    }
    public function gestionSemestres(Request $request){
        return view('administrador.gestion-semestre')
        ->with('semestres',Semestre::getSemestres(1))
        ->with('semestreActual',Semestre::getIdSemestre());
    }

    public function crearSemestre(Request $request){
        //dd($request->all());

       $semestre=new Semestre();

       if($semestre->crearSemestre($request->all(),Auth::id())){
        flash('Se creó el semestre correctamente')->success();
            //return back();
    } else {
        flash($semestre->getMessage())->error();
    }
    return back();      

}

public function editarSemestre(Request $request){

}    

public function seleccionarSemestreSistema(Request $request){
        //dd("HOLA");
    $semestre = new Semestre();          
        //dd($request->get('idSemestre'));
    if($semestre->actualizarSemestreSistema($request->get('idSemestre'),Auth::id())){
        flash('Se cambió de semestre exitosamente')->success();
    } else {
        flash('Hubo un error al tratar de cambiar de semestre')->error();
    }
    return back();
}

public function gestionEspecialidades(Request $request){
    return view('administrador.gestion-especialidad')
    ->with('especialidades',Especialidad::getEspecialidades());
}

public function crearEspecialidad(Request $request){
      $especialidad=new Especialidad();

       if($especialidad->crearEspecialidad($request->get('especialidad'),Auth::id())){
        flash('Se creó la especialidad correctamente')->success();
            //return back();
    } else {
        flash($especialidad->getMessage())->error();
    }
    return back();      
}

public function editarEspecialidad(Request $request){

}
}
