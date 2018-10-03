<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Horario as Horario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $idCurso=$request->get('id',null);
        $nombreCurso=$request->get('nombre',null);
        $codCurso=$request->get('codigo',null);
        //$infoCurso=Prueba::getInformacionCurso($idCurso);
        //$infoCurso trae la información principal del curso en un arreglo  
        return view('cursos.horarios')
        ->with('nombreCurso',$nombreCurso)
        ->with('codCurso',$codCurso)
        ->with('horario',Horario::getHorarios($idCurso));    
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

    function actualizarHorarios(Request $request){
        dd($request->all());
    }




}
