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
        #dd($codigo);
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
        $idProyectos = DB::table('PROYECTOS')->insertGetId(
            $data
        );
        $idAlumno = DB::table('ALUMNOS')
                     ->select(DB::raw('ID_ALUMNO'))
                     ->where('CODIGO', '=', $codigo)
                     ->get();
        dd($idAlumno[0]->ID_ALUMNO);
    	flash('Se ha subido el archivo de forma correcta.')->success();
    	return back();
    }
    public function downfunc(){
    	$downloads = DB::table('proyectos')->get();
    	return view('proyecto.viewfile', compact('downloads'));
    }
}
