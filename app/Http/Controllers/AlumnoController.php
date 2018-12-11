<?php

namespace App\Http\Controllers;

use App\Entity\Base\Entity;
use App\Entity\Alumno as Alumno;
use App\Entity\Curso as Curso;
use App\Entity\Horario as Horario;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


class AlumnoController extends Controller
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

    
    private function trace($cad){
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln("<info>".$cad."</info>");
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
            if($x[$i] == ' ' || $x[$i] == ',') break;
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

    // Ez pushhhhh

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
        return ($ext == 'csv') || ($ext == 'xlsx') || ($ext == 'xls');
    }

    public function uploadAlumnosDeCurso(Request $request){

        $file = $request->file('upload-file');
        if($file==null){
                flash('No ha seleccionado un archivo, inténtelo nuevamente')->error();
                return back();
            }
            
        if($request -> hasFile('upload-file')){
            try{
                /*Archivo debe ser valido*/
                if(!$this->validFile($request->file('upload-file')->getClientOriginalName())){
                    flash('Extension de archivo incorrecta. Revise el formato de archivo adecuado para la carga de alumnos en la parte 
                        inferior del menu lateral.')->error();
                    return Redirect::back();
                }
                // Archivo valido
                $usuario = Auth::user();
                $fecha = date("Y-m-d H:i:s");
                $idSemestre = Entity::getIdSemestre();
                $idEspecialidad = Entity::getEspecialidadUsuario();
                $path = $request->file('upload-file')->getRealPath();
                $data = \Excel::load($path)->get();
                $codCurso = $request->input('codigoCurso');
                $idCurso = Curso::getIdCurso2($codCurso);
				$ans = 0;
				/* Arreglos a llenar*/
	            $alumnosNuevos = array();
	            $alumnosExistentes = array();
	            $alumnosBaneados = array(); // Los alumnos que se quedan fuera porque no pertenecen a ningun horario
	            $alumnosPorHorario = array();
	            // Cada elemento de esto es una estructura que tiene 
	            // 1. Un horario
	            // 2. Un arreglo de alumnos
                $msg = ''; 
                $val = Alumno::uploadAlumnosDeCurso($data, $idCurso, $alumnosNuevos, $alumnosExistentes, $alumnosBaneados, $alumnosPorHorario, $msg);
                if($val == 1){
                    flash('Formato de archivo incorrecto. Revise el formato de archivo adecuado para la carga de alumnos en la parte 
                        inferior del menu lateral.')->error();
                    return Redirect::back();
                }else if($val == 3){
                    flash($msg);
                    return Redirect::back();
                }
                $aux = 10;

                /* EN CASO SE INSERTE DIRECTAMENTE SIN MENSAJE DE CONFIRMACION */
                {
                	$lista = array();
                    // Meter alumnos nuevos
                    foreach($alumnosNuevos as $a){
                        Alumno::trace('ALUMNO NUEVO');
                        Alumno::trace($a['NOMBRES']);
                    	$lista[] = ['NOMBRES' => $a['NOMBRES'],
		                             'APELLIDO_PATERNO' => $a['APELLIDO_PATERNO'],
		                             'APELLIDO_MATERNO' => $a['APELLIDO_MATERNO'],
		                             'CODIGO' => $a['CODIGO'],
		                             'FECHA_REGISTRO' => $fecha,
		                             'FECHA_ACTUALIZACION' => $fecha,
		                             'ID_SEMESTRE'=>$idSemestre,
		                             'ID_ESPECIALIDAD'=>$idEspecialidad,
		                             'USUARIO_MODIF' => $usuario['ID_USUARIO'],
		                             'ESTADO' => 1
		                            ];
                    }
                    DB::table('ALUMNOS')->insert($lista);
                    // Meter alumnos existentes
                    $idAlumnos = array();
                    foreach($alumnosExistentes as $a){
                    	$idAlumnos[] = $a['ID_ALUMNO'];
                    }
                    DB::table('ALUMNOS')
                    		->wherein('ID_ALUMNO',$idAlumnos)
                    		->where('ID_SEMESTRE','=',$idSemestre)
                    		->where('ID_ESPECIALIDAD','=',$idEspecialidad)
                    		->update(['ESTADO' => 1]);
                    // Meter en alumnos_has_horarios
					$lista = array();
					foreach($alumnosPorHorario as $h){
						foreach($h['alumnos'] as $x){
							$lista[] = ['ID_ALUMNO' => $x['ID_ALUMNO'],
                                        'ID_HORARIO' => $h['idHorario'],
                                        'ID_PROYECTO' => 1,
                                        'ID_SEMESTRE' => $idSemestre,
                                        'FECHA_REGISTRO' => $fecha,
                                        'ID_ESPECIALIDAD'=>$idEspecialidad,
                                        'FECHA_ACTUALIZACION' => $fecha,
                                        'USUARIO_MODIF' => $usuario['ID_USUARIO'],
                                        'ESTADO' => 1];
						}
					}
					DB::table('ALUMNOS_HAS_HORARIOS')->insert($lista);
                }
                /* EN CASO SE COMUNIQUE UN MENSAJE DE CONFIRMACION*/

                if($val == 0)
                    flash('Alumnos cargados correctamente')->success();
                else
                    flash('Formato de archivo incorrecto. Revise el formato de archivo adecuado para la carga de alumnos en la parte 
                        inferior del menu lateral.')->error();
            }catch(Exception $e){
                $this->trace($e);
                flash('Formato de archivo incorrecto. Revise el formato de archivo adecuado para la carga de alumnos en la parte 
                        inferior del menu lateral.')->error();
            } 
        }else{
            flash('No se selecciono un archivo')->error();
        }
        return Redirect::back();
    }

    public function store(Request $request){

        $file = $request->file('upload-file');
        if($file==null){
                flash('No ha seleccionado un archivo, inténtelo nuevamente')->error();
                return back();
            }

        if($request->hasFile('upload-file')){
            $this->trace('Request paso');
            try{
                /*Archivo debe ser valido*/
                if(!$this->validFile($request->file('upload-file')->getClientOriginalName())){
                    flash('Extension de archivo incorrecta. Revise el formato de archivo adecuado para la carga de alumnos en la parte 
                        inferior del menu lateral.')->error();
                    return Redirect::back();
                }
                // Archivo valido
                $path = $request->file('upload-file')->getRealPath();
                $data = \Excel::load($path)->get();
                $fecha = date("Y-m-d H:i:s");
                $usuario = Auth::user();
                $idEspecialidad = Entity::getEspecialidadUsuario();
                $id_usuario = Auth::id();
                $semestre_actual = Entity::getIdSemestre();
                $idHorario = $request->input('codigoHorario'); 
                $nombreHorario = $request->input('horario');
                $nombreHorario = $this->fix($nombreHorario);
                $idProyecto = 1; 
                $cont = 0;
                //$idEspecialidad = Entity::getEspecialidadUsuario();
                if($data->count()){
                    //dd($data);
                    $this->trace('Data count');
                    foreach ($data as $key => $value) {
                        
                        $goBack = false;
                        if($value->alumno == null) $goBack = true;
                        if($value->nombre == null) $goBack = true;
                        if($value->horario == null) $goBack = true;
                        if($value->especialidad == null) $goBack = true;
                        if($goBack){
                            flash('Formato de archivo incorrecto. Revise el formato de archivo adecuado para la carga de alumnos en la parte 
                                inferior del menu lateral.')->error();
                            return Redirect::back();
                        }


                        // verificar si alumno ya existe en la BD
                        if($value->horario != $nombreHorario) continue;
                        $cont++;
                        $nombre = $this->getNombre($value->nombre);
                        $apellidoPaterno = $this->getApellidoPaterno($value->nombre);
                        $apellidoMaterno = $this->getApellidoMaterno($value->nombre);
                        $codigo = $value->alumno;
                        if(DB::table('ALUMNOS')->where('CODIGO', $value->alumno)->doesntExist()){
                            // insertar alumno en la bd
                            //dd("goli");
                            DB::table('ALUMNOS')->insert(
                                ['NOMBRES' => $nombre,
                                 'APELLIDO_PATERNO' => $apellidoPaterno,
                                 'APELLIDO_MATERNO' => $apellidoMaterno,
                                 'CODIGO' => $codigo,
                                 'FECHA_REGISTRO' => $fecha,
                                 'FECHA_ACTUALIZACION' => $fecha,
                                 'ID_SEMESTRE'=>$semestre_actual,
                                 'ID_ESPECIALIDAD'=>$idEspecialidad,
                                 'USUARIO_MODIF' => $usuario['ID_USUARIO'],
                                 'ESTADO' => 1
                                ]);
                        }else if( ( DB::table('ALUMNOS')->select('ESTADO')->where('CODIGO',$value->alumno)->get()->toArray() )[0]->ESTADO == 0){
                            DB::table('ALUMNOS')->where('CODIGO',$value->alumno)->update(['ESTADO' => 1]);
                        }
                                           
                        $q = DB::table('ALUMNOS')
                                    ->select('ID_ALUMNO')
                                    ->where('CODIGO', '=', $codigo )->get()->toArray();
                        $idAlumno = (int)($q[0]->ID_ALUMNO);
                        $cond = DB::table('ALUMNOS_HAS_HORARIOS')->
                        whereRaw('ID_ALUMNO = ? AND ID_HORARIO = ? AND ID_PROYECTO = ? AND ID_SEMESTRE = ? AND ID_ESPECIALIDAD',
                            [$idAlumno,$idHorario,$idProyecto,$semestre_actual,$idEspecialidad])->doesntExist();

                        if($cond){
                            $lista[] = ['ID_ALUMNO' => $idAlumno,
                                        'ID_HORARIO' => $idHorario,
                                        'ID_PROYECTO' => $idProyecto,
                                        'ID_SEMESTRE' => $semestre_actual,
                                        'FECHA_REGISTRO' => $fecha,
                                        'ID_SEMESTRE'=>$semestre_actual,
                                        'ID_ESPECIALIDAD'=>$idEspecialidad,
                                        'FECHA_ACTUALIZACION' => $fecha,
                                        'USUARIO_MODIF' => $usuario['ID_USUARIO'],
                                        'ESTADO' => 1];
                        }else{
                            $sql = DB::table('ALUMNOS_HAS_HORARIOS')
                                    ->select('ESTADO')
                                    ->where('ID_ALUMNO','=',$idAlumno)
                                    ->where('ID_HORARIO','=',$idHorario)
                                    ->where('ID_SEMESTRE','=',$semestre_actual)
                                    ->where('ID_PROYECTO','=',$idProyecto)
                                    ->where('ID_ESPECIALIDAD','=',$idEspecialidad)
                                    ->get()->toArray();
                            if($sql[0]->ESTADO == 0){
                                DB::table('ALUMNOS_HAS_HORARIOS')
                                    ->where('ID_ALUMNO','=',$idAlumno)
                                    ->where('ID_HORARIO','=',$idHorario)
                                    ->where('ID_SEMESTRE','=',$semestre_actual)
                                    ->where('ID_PROYECTO','=',$idProyecto)
                                    ->where('ID_ESPECIALIDAD','=',$idEspecialidad)
                                    ->update(['ESTADO' => 1]);
                            }
                        }
                    }
                    if($cont > 0 && !empty($lista))
                        DB::table('ALUMNOS_HAS_HORARIOS')->insert($lista);
                    if($cont > 0)
                        flash('Alumnos cargados correctamente')->success();
                }

                if($cont == 0){
                    $this->trace('No se subio nada');
                    // se subio un archivo donde todos los alumnos no estan en el horario seleccionado
                    flash('Los alumnos del archivo no pertenecen al horario seleccionado o se subio un formato de archivo incorrecto.')->error();
                    $this->trace('Holis');
                    return Redirect::back();
                }
            }catch(Exception $e){
                $this->trace($e);
                flash('Formato de archivo incorrecto. Revise el formato de archivo adecuado para la carga de alumnos.')->error();
                return Redirect::back();
            }
        }else{
            flash('No se selecciono un archivo')->error();
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
}
