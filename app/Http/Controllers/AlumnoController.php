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
            if($x[$i] == ' ') break;
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

    public function uploadAlumnosDeCurso(Request $request){
        dd($request);
        if($request -> hasFile('upload-file')){
            try{
                $path = $request->file('upload-file')->getRealPath();
                $data = \Excel::load($path)->get();
                //$fecha = date("Y-m-d H:i:s");
                //$usuario = Auth::user();
                //$especialidad = Entity::getEspecialidadUsuario();
                //$id_usuario = Auth::id();
                //$semestre_actual = Entity::getIdSemestre();
                $codCurso = $request->input('codCurso'); 
                $this->trace($codCurso);
                //$val = Alumno::uploadAlumnosDeCurso($request);
                $val = 0;
                if($val == 0)
                    flash('Alumnos cargados correctamente')->success();
                else
                    flash('No se pudieron subir los alumnos')->error();
            }
        }else{
            flash('No se selecciono un archivo')->error();
        }
        return Redirect::back();
    }

    public function store(Request $request){

        if($request->hasFile('upload-file')){
            $this->trace('Request paso');
            try{
                $path = $request->file('upload-file')->getRealPath();
                $data = \Excel::load($path)->get();
                $fecha = date("Y-m-d H:i:s");
                $usuario = Auth::user();
                $especialidad = Entity::getEspecialidadUsuario();
                $id_usuario = Auth::id();
                $semestre_actual = Entity::getIdSemestre();
                $idHorario = $request->input('codigoHorario'); 
                $nombreHorario = $request->input('horario');
                $nombreHorario = $this->fix($nombreHorario);
                $idProyecto = 1; 
                $cont = 0;
                //$especialidad = Entity::getEspecialidadUsuario();
                if($data->count()){
                    $this->trace('Data count');
                    foreach ($data as $key => $value) {
                        // verificar si alumno ya existe en la BD
                        if($value->horario != $nombreHorario) continue;
                        $cont++;
                        $nombre = $this->getNombre($value->nombre);
                        $apellidoPaterno = $this->getApellidoPaterno($value->nombre);
                        $apellidoMaterno = $this->getApellidoMaterno($value->nombre);
                        $codigo = $value->alumno;
                        if(DB::table('ALUMNOS')->where('CODIGO', $value->alumno)->doesntExist()){
                            // insertar alumno en la bd
                            DB::table('ALUMNOS')->insert(
                                ['NOMBRES' => $nombre,
                                 'APELLIDO_PATERNO' => $apellidoPaterno,
                                 'APELLIDO_MATERNO' => $apellidoMaterno,
                                 'CODIGO' => $codigo,
                                 'FECHA_REGISTRO' => $fecha,
                                 'FECHA_ACTUALIZACION' => $fecha,
                                 'ID_SEMESTRE'=>$semestre_actual,
                                 'ID_ESPECIALIDAD'=>$especialidad,
                                 'USUARIO_MODIF' => $usuario['ID_USUARIO'],
                                 'ESTADO' => 1
                                ]);
                        }
                                           
                        $q = DB::table('ALUMNOS')
                                    ->select('ID_ALUMNO')
                                    ->where('CODIGO', '=', $codigo )->get()->toArray();
                        //$this->trace('HOLIS2');
                        $idAlumno = (int)($q[0]->ID_ALUMNO);
                        $cond = DB::table('ALUMNOS_HAS_HORARIOS')->
                        whereRaw('ID_ALUMNO = ? AND ID_HORARIO = ? AND ID_PROYECTO = ? AND ID_SEMESTRE = ?',
                            [$idAlumno,$idHorario,$idProyecto,$semestre_actual])->doesntExist();

                        if($cond){
                            $lista[] = ['ID_ALUMNO' => $idAlumno,
                                        'ID_HORARIO' => $idHorario,
                                        'ID_PROYECTO' => $idProyecto,
                                        'ID_SEMESTRE' => $semestre_actual,
                                        'FECHA_REGISTRO' => $fecha,
                                        'ID_SEMESTRE'=>$semestre_actual,
                                        'ID_ESPECIALIDAD'=>$especialidad,
                                        'FECHA_ACTUALIZACION' => $fecha,
                                        'USUARIO_MODIF' => $usuario['ID_USUARIO'],
                                        'ESTADO' => 1];
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
