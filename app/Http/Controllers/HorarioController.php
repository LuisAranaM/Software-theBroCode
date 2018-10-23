<?php

namespace App\Http\Controllers;

use App\Entity\Base\Entity;
use App\Entity\Curso as Curso;
use App\Models\Curso as mCurso;
use DB;
use Excel;
use Illuminate\Http\Request;
use App\Entity\Horario as eHorario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

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
        ->with('horario',eHorario::getHorarios($idCurso));    
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

    public function desactivarHorario(Request $request){
        dd("Holi");
        dd($request->all());
        /*$codigoRes = $request->get('codigo', null);
        $nombreRes = $request->get('nombre', null);
        $idCriterio = eCriterio::insertCriterio($codigoRes,$nombreRes);

        $categoria = $request->get('categoria',null);
        $idCategoria = eCategoria::insertCategoria(1,1,$categoria,$idCriterio);

        $subcriterio = $request->get('indicador',null);
        $texto1 = $request->get('texto1',null);
        $texto2 = $request->get('texto2',null);
        $texto3 = $request->get('texto3',null);
        $texto4 = $request->get('texto4',null);
        eSubcriterio::insertSubCriterio($idCategoria,1,1,$subcriterio, $texto1,$texto2,$texto3,$texto4);
        return redirect()->route('rubricas.gestion');*/

    }


    public function actualizarHorarios(Request $request){
        //dd($request->all());
        //dd(($request->get('idHorarios', null))[0]);
        $idHorarios = $request->get('idHorarios', null);
        $estadoAcreditacion = $request->get('estadoAcreditacion', null);
        eHorario::actualizarHorarios($idHorarios,$estadoAcreditacion);

        $idCurso=$request->get('id',null); 
        $nombreCurso=$request->get('nombre',null);
        $codCurso=$request->get('codigo',null);
        return view('cursos.horarios')
        ->with('nombreCurso',$nombreCurso)
        ->with('codCurso',$codCurso)
        ->with('idCurso',$idCurso)
        ->with('horario',eHorario::getHorarios($idCurso)); 
    }
}
