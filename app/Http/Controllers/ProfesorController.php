<?php

namespace App\Http\Controllers;

use App\Entity\Base\Entity;
use App\Entity\Curso as Curso;
use App\Entity\Horario as Horario;
use App\Entity\Alumnos as eAlumno;
use App\Entity\AlumnosHasHorario as eAlumnosHasHorario;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        //dd($request->all());
        $idHorario=$request->get('idHorario',null); 
        //$infoCurso=Prueba::getInformacionCurso($idCurso);
        //$infoCurso trae la información principal del curso en un arreglo  
        
        return view('profesor.alumnos')
        ->with('curso',Curso::getCursoByIdHorario($idHorario))
        ->with('horario',Horario::getHorarioByIdHorario($idHorario))
        ->with('alumnos',eAlumnosHasHorario::geAlumnosByIdHorario($idHorario));
            
    }

    public function profesorCalificar()
    {
        //dd(Curso::getCursosYHorarios());
        //return view('profesor.calificar');
        return view('profesor.calificar')
        ->with('cursos',Curso::getCursosYHorarios());
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
                    $lista_cursos[] = ['CODIGO_CURSO'=>$value->clave, 'NOMBRE'=>$value->curso, 'ID_ESPECIALIDAD'=>$especialidad, 'ID_SEMESTRE'=>$semestre_actual, 'FECHA_REGISTRO'=> $fecha,
                                        'FECHA_ACTUALIZACION'=> $fecha,'USUARIO_MODIF'=>$id_usuario, 'ESTADO'=>1, 'ESTADO_ACREDITACION'=>0];
                }
                if(!empty($lista_cursos)){
                    #Curso::insert($lista_cursos);
                    DB::table('CURSOS')->insert($lista_cursos);
                    \Session::flash('Éxito', '¡Excel importado con éxito, cursos actualizados!');
                }
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

}
