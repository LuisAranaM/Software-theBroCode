<?php

namespace App\Http\Controllers;


use App\Entity\Base\Entity;
use App\Entity\Curso as Curso;
use App\Models\Curso as mCurso;
use DB;
use Excel;
use Illuminate\Http\Request;
use App\Entity\Horario as eHorario;
use App\Entity\Criterio as eCriterio;
use App\Entity\SubcriteriosHasCurso as eSubcriteriosHasCurso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

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

    public function guardarHorarios(Request $request){

        if($request->hasFile('upload')){
            $path = $request->file('upload-file')->getRealPath();
            $data = \Excel::load($path)->get();
            $fecha = date("Y-m-d H:i:s");
            $usuario = Auth::user();
            $id_usuario = Auth::id();
            $semestre_actual = Entity::getIdSemestre();
            $especialidad = Entity::getEspecialidadUsuario();
            if($data->count()){                 
                foreach ($data as $key => $value) {
                    $auxCurso = $value->clave;
                    $auxIdCurso = (eCurso::buscarCursos($auxCurso))->ID_CURSO;
                    if($auxIdCurso){
                        $lista_horarios = ['ID_CURSO'=>$auxIdCurso, 'ID_ESPECIALIDAD'=>$especialidad, 'SEMESTRES_ID_SEMESTRE'=>$semestre_actual, 
                                            'NOMBRE'=>$value->horario,'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                            'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                        $idCurso = DB::table('HORARIO')->insert($lista_horarios);
                        //por el momento consideremos que solo hay un profesor por curso :c
                        $auxNombProfe = explode(",",$value->nombre);
                        $apellidos = explode(" ",$auxNombProfe[0]);
                        $aPaterno = apellidos[0];
                        $aMaterno = apellidos[1];
                        $nombres = auxNombProfe[1];                       
                                            
                        $idProfe = DB::table('USUARIOS')->insertGetId($lista_profesores);
                        $lista_profesores = [];
                        $lista_profesores = ['ID_ROL'=>4, 'USUARIO'=>$value->codigo, 'CORREO'=>$value->correo, 'FECHA_REGISTRO'=>$fecha,
                                            'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1, 'NOMBRES'=>$nombres,
                                            'APELLIDO_PATERNO'=>$aPaterno, 'APELLIDO_MATERNO=>$aMaterno'];
                       // $lista_profesores = ['ID_ROL'=>4, 'USUARIO'=>$value->codigo, 'CORREO'=>$value->correo, 'FECHA_REGISTRO'=>$fecha,'FECHA_ACTUALIZACION' => $fecha,'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1, 'NOMBRES'= $nombres,'APELLIDO_PATERNO'=>$aPaterno,'APELLIDO_MATERNO'=>$aMaterno ];

                        $listaProfxHor[] = ['ID_USUARIO'=>$idProfe, 'ID_HORARIO'=>$idCurso, 'FECHA_REGISTRO'=>$fecha, 
                                            'FECHA_ACTUALIZACION' => $fecha, 'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1]; 
                    }
                   
                }
                if(!empty($listaProfxHor)){
                    #Curso::insert($lista_cursos);
                    DB::table('PROFESORES_HAS_HORARIOS')->insert($listaProfxHor);
                    \Session::flash('Éxito', '¡Excel importado con éxito, horarios y profesores actualizados!');
                }
                
            }

        }
        else{
            \Session::flash('Error', 'No existe archivo excel para ser importado');
        }
        return Redirect::back();

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
