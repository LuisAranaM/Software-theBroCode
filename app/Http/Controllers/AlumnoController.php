<?php

namespace App\Http\Controllers;

use App\Entity\Base\Entity;
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

    public function store(Request $request){
        if($request->hasFile('upload-file')){
            $path = $request->file('upload-file')->getRealPath();
            $data = \Excel::load($path)->get();
            $fecha = date("Y-m-d H:i:s");
            $usuario = Auth::user();
            $id_usuario = Auth::id();
            $semestre_actual = Entity::getIdSemestre();
            $idHorario = $request->input('codigoHorario'); 
            $idProyecto = 1; 
            //$especialidad = Entity::getEspecialidadUsuario();
            if($data->count()){
                foreach ($data as $key => $value) {
                    // verificar si alumno ya existe en la BD
                    
                    if(DB::table('ALUMNOS')->where('CODIGO', $value->codigo)->doesntExist()){
                        // insertar alumno en la bd
                        DB::table('ALUMNOS')->insert(
                            ['NOMBRES' => $value->nombres,
                             'APELLIDO_PATERNO' => $value->apellido_paterno,
                             'APELLIDO_MATERNO' => $value->apellido_materno,
                             'CODIGO' => $value->codigo,
                             'FECHA_REGISTRO' => $fecha,
                             'FECHA_ACTUALIZACION' => $fecha,
                             'USUARIO_MODIF' => $usuario['ID_USUARIO'],
                             'ESTADO' => 1
                            ]);
                    }
                                       
                    $q = DB::table('ALUMNOS')
                                ->select('ID_ALUMNO')
                                ->where('CODIGO', '=', $value->codigo )->get()->toArray();
                    $this->trace('HOLIS2');
                    $idAlumno = (int)($q[0]->ID_ALUMNO);
                    $cond = DB::table('ALUMNOS_HAS_HORARIOS')->
                    whereRaw('ID_ALUMNO = ? AND ID_HORARIO = ? AND ID_PROYECTO = ? AND SEMESTRES_ID_SEMESTRE = ?',
                        [$idAlumno,$idHorario,$idProyecto,$semestre_actual])->doesntExist();

                    if($cond){
                        $lista[] = ['ID_ALUMNO' => $idAlumno,
                                    'ID_HORARIO' => $idHorario,
                                    'ID_PROYECTO' => $idProyecto,
                                    'SEMESTRES_ID_SEMESTRE' => $semestre_actual,
                                    'FECHA_REGISTRO' => $fecha,
                                    'FECHA_ACTUALIZACION' => $fecha,
                                    'USUARIO_MODIF' => $usuario['ID_USUARIO'],
                                    'ESTADO' => 1];
                    }
                }
                $this->trace('HOLIS3');
                if(!empty($lista)){
                    #Curso::insert($lista_cursos);
                    $this->trace('HOLIS4');
                    DB::table('ALUMNOS_HAS_HORARIOS')->insert($lista);
                    $this->trace('HOLIS5');
                }
                flash('Alumnos cargados correctamente manito')->success();
            }

        }
        else{
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
