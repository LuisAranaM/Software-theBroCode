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

    {//dd(Curso::buscarCursos());
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

    public function subirExcels(){
        return view('subirExcels');
    }

    public function upload(){
        return view('upload');
    }

    public function ExportClients(){
        Excel::create('clients',function($excel){
            $excel->sheet('clients',function($sheet){
                // argumento -> blade
                $sheet->loadView('ExportClients');
            });
        })->export('xlsx');
    }

    public function ImportClients(){
        //dd("HOLA");
        $file = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files',$file_name);
        $results = Excel::load('files/'.$file_name, function($reader){
            $reader->all();
        })->get();
        //return view('/login');
        return view('clients',['clients' => $results]);
    }

    public function buscarCursos(Request $request){

        return Curso::buscarCursos($request->get('termino',$request->get('cursoBuscar',null)));
    }

    public function agregarCursosAcreditacion(Request $request){      
        //dd($request->all());  
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
                /*if(!empty($lista_cursos)){
                    #Curso::insert($lista_cursos);
                    DB::table('CURSOS')->insert($lista_cursos);
                    
                }*/
            }
        }
        else{
            \Session::flash('Error', 'No existe archivo excel para ser importado');
        }
        return Redirect::back();

    }

    public function visualizarData(Request $request){
        //dd($request->all());
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

        $horariosNuevos = [];

        if($data->count()){
            foreach ($data as $key => $value) {
                $horarioTemp = [];
                $profesorTemp = [];                    
                if(($value->clave)!=""){
                    //buscamos el curso                        
                    $auxCurso = new Curso();
                    $idCurso = $auxCurso->getIdCurso($value->clave);
                    //vemos si existe o no
                    $datos_cursos=[];
                    //si no existe ingresamos todos los datos desde cero
                    if(!$idCurso){
                        //ingresamos datos de los cursos
                        //$datos_cursos= ['CODIGO_CURSO'=>$value->clave, 'NOMBRE'=>$value->curso, 'ID_ESPECIALIDAD'=>$especialidad, 'ID_SEMESTRE'=>$semestre_actual,
                        //                'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha,'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1, 'ESTADO_ACREDITACION'=>0];
                        //array_push($listaCursosNuevos,$value->curso);
                        array_push($horarioTemp,$value->clave,$value->curso);                 
                        //$id_curso = DB::table('CURSOS')->insertGetId($datos_cursos);
                        
                        //ingresamos datos de los horarios
                        $codigos_horarios = explode(',',($value->horario));
                        $lista_horarios = [];
                        foreach ($codigos_horarios as $val) {                            
                            //$datos_horario=[];
                            //$datos_horario=['ID_CURSO'=>$id_curso, 'ID_SEMESTRE'=>$semestre_actual, 'ID_ESPECIALIDAD'=>$especialidad, 'NOMBRE'=>$val, 
                            //                'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                            //array_push($listaHorariosNuevos,$value->curso,$val);                
                            array_push($horarioTemp,$val);
                            //$id_horario = DB::table('HORARIOS')->insertGetId($datos_horario);          
                            //array_push($lista_horarios,$id_horario);//guardamos en una array los horarios para luego poder hacer match con el profesor
                            
                        }
                        //ingresamos datos de los profesores
                        $codProf = $value->codigo;
                        //buscamos si existe el profesor
                        $auxProfesor = new Usuario();
                        $idProfesor = $auxProfesor->getIdUsuario($codProf,$value->correo);
                        $auxNombProfe = explode(",",$value->profesor);
                        $auxApellidos = $auxNombProfe[0];
                        $apellidos = explode(" ",$auxApellidos);
                        $aPaterno = $apellidos[0];
                        $aMaterno = $apellidos[1];
                        $nombres = $auxNombProfe[1]; 
                        //si no existe el profesor lo ingresamos
                        if(!$idProfesor){                                
                            //$datos_prof=[];                            
                            //$datos_prof= ['ID_ROL'=>4, 'USUARIO'=>$codProf, 'CORREO'=>$value->correo, 'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha,
                            //              'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>0, 'NOMBRES'=>$nombres, 'APELLIDO_PATERNO'=>$aPaterno, 'APELLIDO_MATERNO'=>$aMaterno];
                            array_push($profesorTemp,$nombres.' '.$aPaterno.' '.$aMaterno,$value->correo);
                            array_push($horarioTemp,$nombres.' '.$aPaterno.' '.$aMaterno,$value->correo);
                            //$idProf = DB::table('USUARIOS')->insertGetId($datos_prof);                                
                            //relacionamos los profesores con sus especialidades
                            /*
                            $u_espec = [];
                            $u_espec = ['ID_USUARIO'=>$idProf, 'ID_ESPECIALIDAD'=>$especialidad, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                        'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                            //DB::table('USUARIOS_HAS_ESPECIALIDADES')->insert($u_espec);
                            //relacionamos los profesores con sus horarios
                            foreach ($lista_horarios as $val) {
                                $prof_hor = [];
                                $prof_hor = ['ID_USUARIO'=>$idProf, 'ID_HORARIO'=>$val, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                             'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                //DB::table('PROFESORES_HAS_HORARIOS')->insert($prof_hor);
                            
                            }
                            */
                        }//si existe
                        else{
                            $idProf=$idProfesor;
                            //array_push($listaProfesoresMantenidos,$nombres,$aPaterno);
                            array_push($horarioTemp,$nombres.' '.$aPaterno.' '.$aMaterno,$value->correo);
                            //relacionamos los profesores con sus horarios
                            /*
                            foreach ($lista_horarios as $val) {
                                $prof_hor = [];
                                $prof_hor = ['ID_USUARIO'=>$idProf, 'ID_HORARIO'=>$val, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                             'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                //DB::table('PROFESORES_HAS_HORARIOS')->insert($prof_hor);
                            
                            }
                            */                                                                
                        }
                        if($horarioTemp != []) array_push($horariosNuevos,$horarioTemp);
                        if($profesorTemp != []) array_push($listaProfesoresNuevos,$profesorTemp);
                        
                    }//entramos aca si existe
                    else{
                        $id_curso=$idCurso;
                        //dd("holis");
                        //array_push($listaCursosMantenidos,$id_curso,$value->curso);
                        //array_push($horarioTemp,$value->clave,$value->curso);                 
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
                                //$datos_horario=[];
                                //$datos_horario=['ID_CURSO'=>$id_curso, 'ID_SEMESTRE'=>$semestre_actual, 'ID_ESPECIALIDAD'=>$especialidad, 'NOMBRE'=>$val, 
                                //                'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                array_push($listaHorariosNuevos,$value->curso,$val);
                                array_push($horarioTemp,$value->clave,$value->curso,$horarioTemp,$val);
                                //$id_horario = DB::table('HORARIOS')->insertGetId($datos_horario);
                                
                            }// si existe el horario en el curso
                            else{
                                $id_horario=$idHorario;
                                //array_push($listaCursosMantenidos,$value->curso,$val);
                            }        
                            array_push($lista_horarios,$id_horario);//guardamos en una array los horarios para luego poder hacer match con el profesor
                        }
                        //ingresamos datos de los profesores
                        $codProf = $value->codigo;
                        //buscamos si existe el profesor
                        $auxProfesor = new Usuario();
                        $idProfesor = $auxProfesor->getIdUsuario($codProf,$value->correo);
                        $auxNombProfe = explode(",",$value->profesor);
                        $auxApellidos = $auxNombProfe[0];
                        $apellidos = explode(" ",$auxApellidos);
                        $aPaterno = $apellidos[0];
                        $aMaterno = $apellidos[1];
                        $nombres = $auxNombProfe[1]; 
                        //si no existe el profesor lo ingresamos
                        if(!$idProfesor){                                
                            //$datos_prof=[];                            
                            //$datos_prof= ['ID_ROL'=>4, 'USUARIO'=>$codProf, 'CORREO'=>$value->correo, 'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha,
                            //              'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>0, 'NOMBRES'=>$nombres, 'APELLIDO_PATERNO'=>$aPaterno, 'APELLIDO_MATERNO'=>$aMaterno];
                            array_push($profesorTemp,$nombres.' '.$aPaterno.' '.$aMaterno,$value->correo);
                            //dd($horarioTemp,"no encontrado");
                            if($horarioTemp!=[]) array_push($horarioTemp,$nombres.' '.$aPaterno.' '.$aMaterno,$value->correo);                            

                            //$idProf = DB::table('USUARIOS')->insertGetId($datos_prof);
                            
                            //relacionamos los profesores con sus especialidades
                            //$u_espec = [];
                            //$u_espec = ['ID_USUARIO'=>$idProf, 'ID_ESPECIALIDAD'=>$especialidad, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                            //            'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                            //DB::table('USUARIOS_HAS_ESPECIALIDADES')->insert($u_espec);
                            //relacionamos los profesores con sus horarios
                            //foreach ($lista_horarios as $val) {
                            //    $prof_hor = [];
                            //    $prof_hor = ['ID_USUARIO'=>$idProf, 'ID_HORARIO'=>$val, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                            //                 'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                            //    DB::table('PROFESORES_HAS_HORARIOS')->insert($prof_hor);
                            //}
                        }//si existe
                        else{
                            $idProf=$idProfesor;
                            array_push($listaProfesoresMantenidos,$nombres.' '.$aPaterno.' '.$aMaterno,$value->correo);
                            //dd($horarioTemp,"encontrado");
                            if($horarioTemp!=[]) array_push($horarioTemp,$nombres.' '.$aPaterno.' '.$aMaterno,$value->correo); 
                             //relacionamos los profesores con sus horarios
                            foreach ($listaHorariosNuevos as $val) {
                                //$prof_hor = [];
                                //$prof_hor = ['ID_USUARIO'=>$idProf, 'ID_HORARIO'=>$val, 'FECHA_REGISTRO'=> $fecha, 'FECHA_ACTUALIZACION'=> $fecha,
                                //             'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1];
                                //DB::table('PROFESORES_HAS_HORARIOS')->insert($prof_hor);
                            }
                        }
                        if($horarioTemp != []) array_push($horariosNuevos,$horarioTemp);
                        if($profesorTemp != []) array_push($listaProfesoresNuevos,$profesorTemp);
                    }
                }
            }

        }
        //dd($listaCursosNuevos,$listaCursosMantenidos,$listaHorariosNuevos,$listaHorariosMantenidos,$listaProfesoresNuevos,$listaProfesoresMantenidos);
        //Arana en estos dos arreglos comentados abajo esta toda la data que necesitas
        dd($horariosNuevos,$listaProfesoresNuevos);

    }

    public function store(Request $request){
        //dd($request->all());
        //$this->visualizarData($request);
        if($request->hasFile('upload-file')){
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
                            $auxNombProfe = explode(",",$value->profesor);
                            $auxApellidos = $auxNombProfe[0];
                            $apellidos = explode(" ",$auxApellidos);
                            $aPaterno = $apellidos[0];
                            $aMaterno = $apellidos[1];
                            $nombres = $auxNombProfe[1]; 
                            //si no existe el profesor lo ingresamos
                            if(!$idProfesor){                                
                                $datos_prof=[];                            
                                $datos_prof= ['ID_ROL'=>4, 'USUARIO'=>$codProf, 'CORREO'=>$value->correo, 'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha,
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
                                }        
                                array_push($lista_horarios,$id_horario);//guardamos en una array los horarios para luego poder hacer match con el profesor
                            }
                            //ingresamos datos de los profesores
                            $codProf = $value->codigo;
                            //buscamos si existe el profesor
                            $auxProfesor = new Usuario();
                            $idProfesor = $auxProfesor->getIdUsuario($codProf,$value->correo);
                            $auxNombProfe = explode(",",$value->profesor);
                            $auxApellidos = $auxNombProfe[0];
                            $apellidos = explode(" ",$auxApellidos);
                            $aPaterno = $apellidos[0];
                            $aMaterno = $apellidos[1];
                            $nombres = $auxNombProfe[1]; 
                            //si no existe el profesor lo ingresamos
                            if(!$idProfesor){                                
                                $datos_prof=[];                            
                                $datos_prof= ['ID_ROL'=>4, 'USUARIO'=>$codProf, 'CORREO'=>$value->correo, 'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha,
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
                        }
                        
                    }                    
                }
                //flash('Las cursos a acreditar se registraron correctamente.')->success();
                flash('¡Excel importado con éxito, cursos actualizados!')->success();
                /*if(!empty($lista_cursos)){
                    #Curso::insert($lista_cursos);
                    DB::table('CURSOS')->insert($lista_cursos);
                    
                }*/
            }
        }
        else{
            \Session::flash('Error', 'No existe archivo excel para ser importado');
        }
        return Redirect::back();
        // //get file
        // $upload = $request->file('upload-file');
        // $filePath = $upload->getRealPath();
        // //open and read
        // $file=fopen($filePath, 'r');

        // $header = fgetcsv($file);

        // //dd($header);
        // //validate
        // $escapedHeader=[];
        // foreach ($header as $key => $value) {
        //     $lheader=strtolower($value);
        //     $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
        //     array_push($escapedHeader, $escapedItem);
        // }

        // //looping 
        
        // while($columns = fgetcsv($file)){
        //     if($columns[0]==""){
        //         continue;
        //     }
        //     foreach ($columns as $key => &$value) {
        //         $value = preg_replace('/\D/', '', $value);
        //     }
        //     $data = array_combine($escapedHeader, $columns);
        //     //setting type
        //     foreach ($data as $key => &$value) {
        //         $value = ($key=="zip" || $key =="month")?(integer)$value:(string)$value;
        //     }
        //     //table update
        //     $date = date("Y-m-d", time());

        //     $nombre = $data['nombre'];
        //     $CODIGO_CURSO = $data['codigocurso'];
        //     $FECHA_REGISTRO = $date;
        //     $FECHA_ACTUALIZACION = $date;
        //     $ESTADO_ACREDITACION = 1;
        //     $USUARIO_MODIF = 1;
        //     $ESTADO = 1;

        //     $curso = Curso::updateOrCreate(['nombre'=>$nombre]);
        //     $curso->CODIGO_CURSO = $CODIGO_CURSO;
        //     $curso->FECHA_REGISTRO = $date;
        //     $curso->FECHA_ACTUALIZACION = $date;
        //     $curso->ESTADO_ACREDITACION = 1;
        //     $curso->USUARIO_MODIF = 1;
        //     $curso->ESTADO = 1;
        /*    $curso->save();
            
        
    }*/
    

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
        //dd(Curso::getCursosByResultado($idSemestre, $idResultado));
        return Curso::getCursosByResultado($idSemestre, $idResultado);
    }
}
