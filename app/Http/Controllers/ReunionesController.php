<?php

namespace App\Http\Controllers;
use App\Entity\PlanesDeMejora as PlanesDeMejora;
use App\Entity\Acta as Acta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Entity\Base\Entity;
use DB;




class ReunionesController extends Controller
{
    //

    public function reunionesGestion() {    
        return view('reuniones.reuniones');
    }
    public function store(Request $request){
        $tipoDoc = $request->get('tipoDoc', null); //ver si es acta o plan el value
        $ano = $request->get('ano', null);
        $semestre = $request->get('semestre', null);
        $file = $request->file('archivo');
        #$semestre_actual = Entity::getIdSemestre();
        $semestreActual = Entity::getIdSemestre();
        $especialidad = Entity::getEspecialidadUsuario();
        //dd($especialidad);
        $usuario = Auth::user();
        $idUsuario = Auth::id();
        $nameOfFile = pathinfo(Input::file('archivo')->getClientOriginalName(), PATHINFO_FILENAME);
        $extensionOfFile = pathinfo(Input::file('archivo')->getClientOriginalName(), PATHINFO_EXTENSION);  //Get extension of file
        $file->storePubliclyAs('upload', $nameOfFile.'.'.$extensionOfFile, 'public');
        //dd("HOLA");
        $path = base_path() . '\public\upload' . '\\' . $nameOfFile.'.'.$extensionOfFile ;
        $fecha = date("Y-m-d H:i:s");

        dd($semestre);
    	#creationg array for data
    	$data = array('RUTA'=>$path, 'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$idUsuario,'ESTADO'=>1, 'NOMBRE'=>$nameOfFile.'.'.$extensionOfFile,'ID_SEMESTRE'=>$semestreActual,'ID_ESPECIALIDAD'=>$especialidad, 'anoDoc'=>$ano, 'semestreDoc'=>$semestre);
        $idProyecto = DB::table('PROYECTOS')->insertGetId(
            $data
        );
        //dd($data);
        $idAlumno = DB::table('ALUMNOS')
                     ->select('ID_ALUMNO')
                     ->where('CODIGO', '=', $codigo)
                     ->get();
        $idHorario = DB::table('HORARIOS')
                     ->select('ID_HORARIO')
                     ->where('NOMBRE', '=', $horario)
                     ->get();
        #ahora insertaré en alumnos_has_horarios los atributos correspondientes para anexar el file subido al alumno en el horario respectivo

        $dataAlumnoxHorario = array('ID_ALUMNO'=>$idAlumno[0]->ID_ALUMNO, 'ID_HORARIO'=>$horario, 'ID_PROYECTO'=>$idProyecto, 'ID_SEMESTRE'=>$semestreActual,'FECHA_REGISTRO'=>$fecha, 'FECHA_ACTUALIZACION'=>$fecha, 'USUARIO_MODIF'=>$idUsuario,'ESTADO'=>1,'ID_ESPECIALIDAD'=>$especialidad);
        $idAlumnoHasHorarios = DB::table('ALUMNOS_HAS_HORARIOS')->insertGetId(
            $dataAlumnoxHorario
        );
    	flash('Se ha subido el archivo de forma correcta.')->success();
    	return back();
    }
}
