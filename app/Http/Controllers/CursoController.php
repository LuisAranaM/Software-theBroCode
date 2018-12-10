<?php

namespace App\Http\Controllers;

use App\Entity\Base\Entity;
use DB;
use App\Entity\Curso as Curso;
use App\Entity\Horario as Horario;
use App\Entity\Usuario as Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;

use Excel;
use Validator;


class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()

    {
       return view('cursos.gestion')
        ->with('cursos',Curso::getCursosAcreditacion())
        ->with('cursosBuscar',Curso::buscarCursos(null,false));
    }
    
    public function progresoGestion() {

        $horarios=[];
        $cursos = Curso::getCursosAcreditacion();
        foreach ($cursos as $curso){
            $idCurso = $curso->ID_CURSO;
            $horarios[$idCurso] = Horario::getHorarios($idCurso);
        }
        return view('cursos.progreso')
        ->with('idCurso',$idCurso)
        ->with('horarios',$horarios)
        ->with('cursos',Curso::getCursosAcreditacion());
    }

    public function buscarCursos(Request $request){

        return Curso::buscarCursos($request->get('termino',$request->get('cursoBuscar',null)));
    }

    public function agregarCursosAcreditacion(Request $request){      
        $checks=$request->get('checkCursos',null);
        
        $curso = new Curso();           
        
        if($curso->agregarAcreditar($checks,Auth::id())){
            flash('Las cursos a acreditar se registraron correctamente.')->success();
        } else {
            flash('Hubo un error al registrar los cursos a acreditar.')->error();
        }
        return back();

    }

    public function eliminarCursoAcreditacion(Request $request){        
        
        $validator = Validator::make($request->all(), [
            'codigoCurso' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array_flatten($validator->errors()->getMessages()), 404);
        }

        $curso = new Curso();          

        if($curso->eliminarAcreditar($request->get('codigoCurso'),Auth::id())){
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
    public function showForm(){
        return view('upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    
    public function getCursosbyIdSemestre(Request $request){
        return Curso::getCursosbyIdSemestre($request->get('idSemestre',null));
    }

    public function guardarCursosHorariosProfesores(Request $request){
        if($request->hasFile('upload-file')){
            $path = $request->file('upload-file')->getRealPath();
            $data = \Excel::load($path)->get();
            $fecha = date("Y-m-d H:i:s");
            $usuario = Auth::user();
            $id_usuario = Auth::id();
            $semestre_actual = Entity::getIdSemestre();
            $especialidad = Entity::getEspecialidadUsuario();
            if($data->count()){
                foreach ($data as $key => $value) {                    
                    if(($value->clave)!=""){
                        //buscamos el curso
                        
                        $auxCurso = new Curso();
                        $idCurso = $auxCurso->getIdCurso($value->clave);
                        //primero ingresamos curso
                        //dd($idCurso);
                        $datos_cursos=[];
                        if($idCurso==null){

                            $datos_cursos= ['CODIGO_CURSO'=>$value->clave, 'NOMBRE'=>$value->curso, 'ID_ESPECIALIDAD'=>$especialidad, 'ID_SEMESTRE'=>$semestre_actual, 'FECHA_REGISTRO'=> $fecha,
                            'FECHA_ACTUALIZACION'=> $fecha,'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1, 'ESTADO_ACREDITACION'=>0];
                            $id_curso = DB::table('CURSOS')->insertGetId($datos_cursos);
                        }
                        else{
                            $id_curso=$idCurso;
                            //dd($id_curso);

                        }                   
                        //luego ingresamos sus horarios
                        $codigos_horarios = explode(',',((string)$value->horario));                        
                        $lista_horarios = [];
                        foreach ($codigos_horarios as $val) {                            
                            $datos_horario=[];
                            $datos_horario=['ID_CURSO'=>$id_curso, 'ID_SEMESTRE'=>$semestre_actual, 'ID_ESPECIALIDAD'=>$especialidad,
                            'NOMBRE'=>$val,'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                            'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];

                            $id_horario = DB::table('HORARIOS')->insertGetId($datos_horario);   
                            //dd($id_horario);            
                            array_push($lista_horarios,$id_horario);
                            //dd($lista_horarios);
                        }
                        //dd("holis");
                        //ahora ingresaremos los profesores como usuarios
                        $codProf = $value->codigo;
                        //dd($codProf);
                        $model = new Usuario();
                        $idProf = $model->getIdUsuario($codProf);
                        //dd($idProf);
                        //si no existe, si existe ya tenemos el id
                        if(!$idProf){
                            $auxNombProfe = explode(",",$value->profesor);
                            $auxApellidos = $auxNombProfe[0];
                            $apellidos = explode(" ",$auxApellidos);
                            $aPaterno = $apellidos[0];
                            $aMaterno = $apellidos[1];
                            $nombres = $auxNombProfe[1]; 
                            $datos_prof=[];                            
                            $datos_prof= ['ID_ROL'=>4, 'USUARIO'=>$codProf, 'CORREO'=>$value->correo, 'FECHA_REGISTRO'=>$fecha,
                            'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1, 'NOMBRES'=>$nombres,
                            'APELLIDO_PATERNO'=>$aPaterno, 'APELLIDO_MATERNO'=>$aMaterno];
                            $idProf = DB::table('USUARIOS')->insertGetId($datos_prof);
                        }


                        //llenar usuario_has_especialidad
                        $u_espec = [];
                        $u_espec = ['ID_USUARIO'=>$idProf, 'ID_ESPECIALIDAD'=>$especialidad, 'FECHA_REGISTRO'=> $fecha,
                        'FECHA_ACTUALIZACION'=> $fecha,'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                        DB::table('USUARIOS_HAS_ESPECIALIDADES')->insert($u_espec);
                        //en este punto solo queda hacer la tabla horarios x prof
                        foreach ($lista_horarios as $val) {
                            $prof_hor = [];
                            $prof_hor = ['ID_USUARIO'=>$idProf, 'ID_HORARIO'=>$val, 'FECHA_REGISTRO'=> $fecha,
                            'FECHA_ACTUALIZACION'=> $fecha,'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                            DB::table('PROFESORES_HAS_HORARIOS')->insert($prof_hor);                            
                        }
                        

                        
                    }                    
                }
                \Session::flash('Éxito', '¡Excel importado con éxito, cursos actualizados!');
               
            }
        }
        else{
            \Session::flash('Error', 'No existe archivo excel para ser importado');
        }
        return Redirect::back();

    }

    private function getNombre($x){
        $ans = '';
        $valid = false;
        for($i = 0; $i < strlen($x); $i++){
            if($valid) $ans .= $x[$i];
            if($x[$i] == ','){
                $i++;
                $valid = true;
            }
        }
        return $ans;
    }

    private function getApellidoPaterno($x){
        $ans = '';
        for($i = 0; $i < strlen($x); $i++){
            if( ($x[$i] == ' ') || ($x[$i] == ',') ) break;
            $ans .= $x[$i];
        }
        return $ans;
    }

    private function getApellidoMaterno($x){
        $ans = '';
        $valid = false;
        for($i = 0; $i < strlen($x); $i++){
            if($x[$i] == ',') break;
            if($valid) $ans .= $x[$i];
            if($x[$i] == ' ') $valid = true;
        }
        return $ans;
    }

    private function fix($cad){
        $ans = '';
        $i = 0;
        if($cad[0] == '0') $i++;
        for(; $i < strlen($cad); $i++)
            $ans .= $cad[$i];
        return $ans;
    }

    private function validFile($x){
        $i = 0; $point = false;
        for(; $i < strlen($x); $i++)
            if($x[$i] == '.'){
                $point = true;
                break;
            }
        if(!$point) return false;
        $ext = "";
        for($i++; $i < strlen($x); $i++)
            $ext .= $x[$i];
        return ($ext == 'csv') || ($ext == 'xlsx');
    }

    public function store(Request $request){
        $file = $request->file('upload-file');
        if($file==null){
                flash('No ha seleccionado un archivo, inténtelo nuevamente')->error();
                return back();
            }
        if($request->hasFile('upload-file')){
            if(!$this->validFile($request->file('upload-file')->getClientOriginalName())){
                    flash('Formato de archivo incorrecto. Revise el formato de archivo adecuado para la carga de cursos')->error();
                    return Redirect::back();
            }

            $path = $request->file('upload-file')->getRealPath();
            $data = \Excel::load($path)->get();
            $fecha = date("Y-m-d H:i:s");
            $usuario = Auth::user();
            $id_usuario = Auth::id();
            $semestre_actual = Entity::getIdSemestre();
            $especialidad = Entity::getEspecialidadUsuario();
            $listaCursosNuevos = [];
            $listaCursosMantenidos = [];
            $listaHorariosNuevos = [];
            $listaHorariosMantenidos = [];
            $listaProfesoresNuevos = [];
            $listaProfesoresMantenidos = [];
            //si el archivo tiene datos
            if($data->count()){
                foreach ($data as $key => $value) {                    
                    if(($value->clave)!=""){
                        //buscamos el curso                        
                        $auxCurso = new Curso();
                        $idCurso = $auxCurso->getIdCurso($value->clave);
                        //vemos si existe o no
                        $datos_cursos=[];
                        //si no existe ingresamos todos los datos desde cero
                        if(!$idCurso){

                            //ingresamos datos de los cursos
                            $datos_cursos= ['CODIGO_CURSO'=>$value->clave, 'NOMBRE'=>$value->curso, 'ID_ESPECIALIDAD'=>$especialidad, 'ID_SEMESTRE'=>$semestre_actual,
                            'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha,'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1, 'ESTADO_ACREDITACION'=>0];
                            array_push($listaCursosNuevos,$value->curso);                 
                            $id_curso = DB::table('CURSOS')->insertGetId($datos_cursos);
                            
                            //ingresamos datos de los horarios
                            $codigos_horarios = explode(',',($value->horario));
                            $lista_horarios = [];
                            foreach ($codigos_horarios as $val) {                            
                                $datos_horario=[];
                                $datos_horario=['ID_CURSO'=>$id_curso, 'ID_SEMESTRE'=>$semestre_actual, 'ID_ESPECIALIDAD'=>$especialidad, 'NOMBRE'=>$val, 
                                'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                array_push($listaHorariosNuevos,$value->curso,$val);                
                                $id_horario = DB::table('HORARIOS')->insertGetId($datos_horario);          
                                array_push($lista_horarios,$id_horario);//guardamos en una array los horarios para luego poder hacer match con el profesor
                                
                            }
                            //ingresamos datos de los profesores
                            $codProf = $value->codigo;
                            //buscamos si existe el profesor
                            $auxProfesor = new Usuario();
                            $idProfesor = $auxProfesor->getIdUsuario($codProf,$value->correo);
                            //$auxNombProfe = $this->getNombre($value->profesor);
                            //$auxApellidos = $auxNombProfe[0];
                            //$apellidos = explode(" ",$auxApellidos);
                            $aPaterno = $this->getApellidoPaterno($value->profesor);
                            $aMaterno = $this->getApellidoMaterno($value->profesor);
                            $nombres = $this->getNombre($value->profesor); 
                            //si no existe el profesor lo ingresamos
                            if(!$idProfesor){                                
                                $datos_prof=[];                            
                                $datos_prof= ['ID_ROL'=>4, 'USUARIO'=>$codProf, 'PASS'=>Hash::make($codProf), 'CORREO'=>$value->correo, 'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha,
                                'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>0, 'NOMBRES'=>$nombres, 'APELLIDO_PATERNO'=>$aPaterno, 'APELLIDO_MATERNO'=>$aMaterno];
                                array_push($listaProfesoresNuevos,$nombres,$aPaterno);
                                $idProf = DB::table('USUARIOS')->insertGetId($datos_prof);                                
                                //relacionamos los profesores con sus especialidades
                                $u_espec = [];
                                $u_espec = ['ID_USUARIO'=>$idProf, 'ID_ESPECIALIDAD'=>$especialidad, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                DB::table('USUARIOS_HAS_ESPECIALIDADES')->insert($u_espec);
                                //relacionamos los profesores con sus horarios
                                foreach ($lista_horarios as $val) {
                                    $prof_hor = [];
                                    $prof_hor = ['ID_USUARIO'=>$idProf, 'ID_HORARIO'=>$val, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                    'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                    DB::table('PROFESORES_HAS_HORARIOS')->insert($prof_hor);
                                }
                            }//si existe
                            else{
                                $idProf=$idProfesor;
                                array_push($listaProfesoresMantenidos,$nombres,$aPaterno);
                                //relacionamos los profesores con sus horarios
                                foreach ($lista_horarios as $val) {
                                    $prof_hor = [];
                                    $prof_hor = ['ID_USUARIO'=>$idProf, 'ID_HORARIO'=>$val, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                    'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                    DB::table('PROFESORES_HAS_HORARIOS')->insert($prof_hor);
                                }                                                                
                            }  
                            
                        }//entramos aca si existe
                        else{
                            $id_curso=$idCurso;
                            array_push($listaCursosMantenidos,$id_curso,$value->curso);
                            //ingresamos datos de los horarios
                            $codigos_horarios = explode(',',($value->horario));
                            $lista_horarios = [];
                            foreach ($codigos_horarios as $val) {
                                //buscamos si ese horario existe dentro del curso
                                $auxHorario = new Horario();
                                $idHorario = $auxHorario->getIdHorario($val,$id_curso);
                                //dd($val,$id_curso);
                                //dd($idHorario);
                                //si no existe el horario ingresamos la data como esta
                                if(!$idHorario){
                                    $datos_horario=[];
                                    $datos_horario=['ID_CURSO'=>$id_curso, 'ID_SEMESTRE'=>$semestre_actual, 'ID_ESPECIALIDAD'=>$especialidad, 'NOMBRE'=>$val, 
                                    'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                    array_push($listaHorariosNuevos,$value->curso,$val);
                                    $id_horario = DB::table('HORARIOS')->insertGetId($datos_horario);
                                    
                                }// si existe el horario en el curso
                                else{
                                    $id_horario=$idHorario;
                                    array_push($listaCursosMantenidos,$value->curso,$val);
                                    array_push($listaHorariosMantenidos,$idHorario);
                                }        
                                array_push($lista_horarios,$id_horario);//guardamos en una array los horarios para luego poder hacer match con el profesor
                            }
                            //ingresamos datos de los profesores
                            $codProf = $value->codigo;
                            //buscamos si existe el profesor
                            $auxProfesor = new Usuario();
                            $idProfesor = $auxProfesor->getIdUsuario($codProf,$value->correo);
                            //$auxNombProfe = explode(",",$value->profesor);
                            //$auxApellidos = $auxNombProfe[0];
                            //$apellidos = explode(" ",$auxApellidos);
                            $aPaterno = $this->getApellidoPaterno($value->profesor);
                            $aMaterno = $this->getApellidoMaterno($value->profesor);
                            $nombres = $this->getNombre($value->profesor);  
                            //si no existe el profesor lo ingresamos
                            if(!$idProfesor){                                
                                $datos_prof=[];                            
                                $datos_prof= ['ID_ROL'=>4, 'USUARIO'=>$codProf,'PASS'=>Hash::make($codProf), 'CORREO'=>$value->correo, 'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha,
                                'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>0, 'NOMBRES'=>$nombres, 'APELLIDO_PATERNO'=>$aPaterno, 'APELLIDO_MATERNO'=>$aMaterno];
                                array_push($listaProfesoresNuevos,$nombres,$aPaterno);
                                $idProf = DB::table('USUARIOS')->insertGetId($datos_prof);
                                
                                //relacionamos los profesores con sus especialidades
                                $u_espec = [];
                                $u_espec = ['ID_USUARIO'=>$idProf, 'ID_ESPECIALIDAD'=>$especialidad, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                DB::table('USUARIOS_HAS_ESPECIALIDADES')->insert($u_espec);
                                //relacionamos los profesores con sus horarios
                                foreach ($lista_horarios as $val) {
                                    $prof_hor = [];
                                    $prof_hor = ['ID_USUARIO'=>$idProf, 'ID_HORARIO'=>$val, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                    'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                    DB::table('PROFESORES_HAS_HORARIOS')->insert($prof_hor);
                                }
                            }//si existe
                            else{
                                $idProf=$idProfesor;
                                array_push($listaProfesoresMantenidos,$nombres,$aPaterno);
                                 //relacionamos los profesores con sus horarios
                                 
                                foreach ($listaHorariosNuevos as $val) {
                                    $prof_hor = [];
                                    $prof_hor = ['ID_USUARIO'=>$idProf, 'ID_HORARIO'=>$val, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                    'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                    DB::table('PROFESORES_HAS_HORARIOS')->insert($prof_hor);
                                }                                                              
                            }
                            //romper la relacion logicamente entre el profesor antiguo de los cursos antiguos
                            if($listaHorariosMantenidos != null && $listaHorariosNuevos != null){
                                foreach($listaHorariosMantenidos as $horario){
                                    DB::table('PROFESORES_HAS_HORARIOS')
                                    ->where('ID_HORARIO','=',$horario)
                                    ->where('ID_USUARIO','!=',$idProf)
                                    ->update(['ESTADO'=>0]);
                                }
                            } 
                        }
                        
                    }                    
                }
                //flash('Las cursos a acreditar se registraron correctamente.')->success();
                flash('¡Excel importado con éxito, cursos actualizados!')->success();
            }
        }
        else{
            \Session::flash('Error', 'No existe archivo excel para ser importado');
        }
        return Redirect::back();
        
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

    public function getCursosByResultado(Request $request){
        $idSemestre = $request->get('idSemestre', null);
        $idResultado = $request->get('idResultado', null);
        return Curso::getCursosByResultado($idSemestre, $idResultado);
    }
    public function graficoHorariosxResultado(Request $request){
        $idSemestre = $request->get('idSemestre', null);
        $idResultado = $request->get('idResultado', null);
        $idCurso= $request->get('idCurso', null);
        return Curso::graficoHorariosxResultado($idSemestre, $idResultado, $idCurso);
    }
    
}
