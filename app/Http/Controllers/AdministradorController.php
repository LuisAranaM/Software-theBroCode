<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Usuario as Usuario;
use App\Entity\Rol as Rol;
use App\Entity\Especialidad as Especialidad;

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
        $filtros=[
            'page' => $request->get('page',1),
        ];
        $orden=[];
        return view('administrador.gestion-usuario')
        ->with('usuarios',Usuario::getUsuariosGestion($filtros,$orden)->setPath(config('app.url').'admin/gestionar-usuario'))
        ->with('filtros',$filtros)
        ->with('orden',$orden)
        ->with('roles',Rol::getRoles())
        ->with('especialidades',Especialidad::getEspecialidades());
    }

        public function crearCuentaRubrik(Request $request){
        //dd($request->all());

        //Registraremos el usuario y nos loguearemos
        $usuario=new Usuario();

        if($usuario->crearCuentaRubrik($request->all())){
            flash('Se registró el usuario correctamente')->success();
            //return back();
        } else {
            flash($usuario->getMessage())->error();
        }
            return back();      
        

    }

    public function gestionSemestres(Request $request){
        return view('administrador.gestion-semestre');
    }
    public function gestionEspecialidades(Request $request){
        return view('administrador.gestion-especialidad');
    }
}
