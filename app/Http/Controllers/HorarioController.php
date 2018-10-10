<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Horario as eHorario;
use App\Entity\Criterio as eCriterio;
use App\Entity\SubcriteriosHasCurso as eSubcriteriosHasCurso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Validator;

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
        ->with('idCurso',$idCurso)
        ->with('horario',eHorario::getHorarios($idCurso))
        ->with('criterios',eCriterio::getCriteriosbyIdCurso($idCurso))
        ->with('subcriterios',eSubcriteriosHasCurso::getSubCriteriosbyIdCurso($idCurso));
            
    }

    public function eliminarEvaluacionHorarios(Request $request){        
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'codigoHorario' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array_flatten($validator->errors()->getMessages()), 404);
        }
        $horario = new eHorario();          
        if($horario->eliminarEvaluacion($request->get('codigoHorario'),Auth::id())){
            flash('El curso se eliminó con éxito')->success();
        } else {
            flash('Hubo un error al tratar de eliminar el curso')->error();
        }
        return back();
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



    public function actualizarHorarios(Request $request){
        //dd($request->all());
        //dd(($request->get('idHorarios', null))[0]);
        $idHorarios = $request->get('idHorarios', null);
        $estadoEvaluacion = $request->get('estadoEvaluacion', null);

        $validator = Validator::make($request->all(), [
            'idHorarios' => 'required',
            'estadoEvaluacion' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array_flatten($validator->errors()->getMessages()), 404);
        }
        $horario = new eHorario();   
        if($horario->actualizarHorarios($idHorarios,$estadoEvaluacion,Auth::id())){
            flash('El curso se eliminó con éxito')->success();
        } else {
            flash('Hubo un error al tratar de eliminar el curso')->error();
        }
        return back();
    }
}
