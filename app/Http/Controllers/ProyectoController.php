<?php

namespace App\Http\Controllers;


use App\Entity\Base\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use DB;


class ProyectoController extends Controller
{
    public function index(){
    	return view('proyecto.index');
    }

    public function store(Request $request){

        $codigo = $request->get('codAlumno', null);
        $horario = $request->get('horario', null);
    	$file = $request->file('archivo');
    	$semestre_actual = Entity::getIdSemestre();
    	$especialidad = Entity::getEspecialidadUsuario();
    	$usuario = Auth::user();
    	$id_usuario = Auth::id();
    	$name_of_file = pathinfo(Input::file('archivo')->getClientOriginalName(), PATHINFO_FILENAME);
    	$extension_of_file = pathinfo(Input::file('archivo')->getClientOriginalName(), PATHINFO_EXTENSION);  //Get extension of file
    	$file->storePubliclyAs('upload', $name_of_file.'.'.$extension_of_file, 'public');
    	$path = base_path() . '\public\upload' . '\\' . $name_of_file.'.'.$extension_of_file ;
    	$fecha = date("Y-m-d H:i:s");

    	#creationg array for data
    	$data = array('RUTA'=>$path, 'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$id_usuario,'ESTADO'=>1, 'NOMBRE'=>$name_of_file.'.'.$extension_of_file);
        $idProyecto = DB::table('PROYECTOS')->insertGetId(
            $data
        );
        $idAlumno = DB::table('ALUMNOS')
                     ->select(DB::raw('ID_ALUMNO'))
                     ->where('CODIGO', '=', $codigo)
                     ->get();
        $idHorario = DB::table('HORARIOS')
                     ->select(DB::raw('ID_HORARIO'))
                     ->where('NOMBRE', '=', $horario)
                     ->get();
        #ahora insertaré en alumnos_has_horarios los atributos correspondientes para anexar el file subido al alumno en el horario respectivo
        $dataAlumnoxHorario = array('ID_ALUMNO'=>$idAlumno[0]->ID_ALUMNO, 'ID_HORARIO'=>$idHorario[0]->ID_HORARIO, 'ID_PROYECTO'=>$idProyecto, 'SEMESTRES_ID_SEMESTRE'=>$id_usuario,'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$id_usuario,'ESTADO'=>1);
        $idAlumnoHasHorarios = DB::table('ALUMNOS_HAS_HORARIOS')->insertGetId(
            $dataAlumnoxHorario
        );
    	flash('Se ha subido el archivo de forma correcta.')->success();
    	return back();
    }
    public function downfunc(){
    	$downloads = DB::table('PROYECTOS')->get();
    	return view('proyecto.viewfile', compact('downloads'));
    }

    public function descargarProyecto(Request $request){
        dd("holi");
    }

}
