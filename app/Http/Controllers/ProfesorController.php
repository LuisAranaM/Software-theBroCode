<?php

namespace App\Http\Controllers;

use App\Entity\Base\Entity;
use App\Entity\Curso as Curso;
use App\Entity\Horario as Horario;
use App\Entity\Alumno as eAlumno;
use App\Entity\AlumnosHasHorario as eAlumnosHasHorario;
use App\Entity\Resultado as eResultado;
use App\Entity\IndicadoresHasCurso as eIndicadoresHasCurso;
use App\Entity\Indicador as eIndicador;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Entity\Proyecto as Proyecto;

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
        $idCurso=$request->get('idCurso',null); 
        
        //$infoCurso=Prueba::getInformacionCurso($idCurso);
        //$infoCurso trae la información principal del curso en un arreglo  
        //dd($idHorario);
        //dd(Proyecto::getRutaProyectos($idHorario));
        //d
        //dd(eAlumnosHasHorario::getAlumnosByIdHorario($idHorario),eAlumnosHasHorario::getAlumnoXHorario($idHorario));
        //dd(eIndicadoresHasCurso::getIndicadoresbyIdCurso($idCurso),eIndicador::getIndicadores());
        //dd(eResultado::getResultadosbyIdCurso($idCurso));
        //dd(eResultado::getResultadosbyIdCurso($idCurso));
        //
        //dd(eAlumnosHasHorario::getAlumnoXHorario($idHorario));
        return view('profesor.alumnos')
        ->with('curso',Curso::getCursoByIdHorario($idHorario))
        ->with('horario',Horario::getHorarioByIdHorario($idHorario))
        ->with('alumnos',eAlumnosHasHorario::getAlumnosByIdHorario($idHorario))
       // ->with('alumnosxhorario',eAlumnosHasHorario::getAlumnoXHorario($idHorario)); //revisar
        ->with('projects',Proyecto::getRutaProyectos($idHorario))
        ->with('resultados',eResultado::getResultadosbyIdCurso($idCurso))
        ->with('indicadores',eIndicadoresHasCurso::getIndicadoresbyIdCurso($idCurso))
        ->with('todoIndicadores',eIndicador::getIndicadores());  
    }

    public function profesorCalificar()
    {
        //dd(Curso::getCursosYHorarios());
        //return view('profesor.calificar');
        //dd(Curso::getCursosYHorarios());
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

    public function fetchResultados(Request $request){
        //Debemos de traer el ID_Alumno o el ID_Horario a futuro
        $idCurso=$request->get('idCurso',null);
        $idHorario=$request->get('idHorario',null);
        $idResultado=$request->get('idResultado',null);
        $idAlumno=$request->get('idAlumno',null);
        //dd($resultado);
        if($idResultado!=NULL){
         $output = '';
         $resultado=eResultado::getResultadosbyIdCurso($idCurso,$idResultado);
         $previous = eResultado::getResultadosbyIdCurso($idCurso,$idResultado,'desc');
         $next = eResultado::getResultadosbyIdCurso($idCurso,$idResultado,'asc');
         $infoResultado=eIndicador::getInfoResultadoAlumno($idResultado,$idCurso,$idAlumno,$idHorario);

           //dd($infoResultado);
            //Falta armar el esquema con el de Yoluana
              /*$output .= '
              <h2>'.$resultado->NOMBRE.'</h2>
              <p><label>Author By - '.$resultado->NOMBRE.'</label></p>
              <p>'.$resultado->DESCRIPCION.'</p>
              ';*/
              $html='';
              $html.='<label> Resultado:'.$resultado->NOMBRE.'</label><br>';
              $html.='<label>'.$resultado->DESCRIPCION.'</label>';

              $html.='<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">';
              foreach ($infoResultado as $indicador) {
                $html.='<div class="panel"><a class="panel-heading collapsed" role="tab" id="heading'.$indicador['ID_INDICADOR'].'" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$indicador['ID_INDICADOR'].'" aria-expanded="false" aria-controls="collapse'.$indicador['ID_INDICADOR'].'">
                <div class="row"><div class="col-xs-3"><div class="text-left"><p class="smallText" style="padding-left:15px; padding-right: 15px; padding-top: 8px">'.$resultado->NOMBRE.' '.$indicador['ID_INDICADOR'].'<br></div></div><div class="col-xs-9"><div class="text-left"><p class="smallText" style="padding-left:15px; padding-right: 15px; padding-top: 8px">'.$indicador['NOMBRE_INDICADOR'].'<br></div></div></div></a>';

                $html.='<div id="collapse'.$indicador['ID_INDICADOR'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$indicador['ID_INDICADOR'].'" aria-expanded="false" style="height: 0px;"><div class="panel-body"><div class="row" style="padding-top: 10px; padding-bottom: 10px;"><div class="btn-group btn-group-justified" data-toggle="buttons">';
                foreach($indicador['DESCRIPCIONES'] as $descripcion){
                    $checked='';
                    $active='';
                    if($descripcion['ESCALA_CALIFICACION']!=NULL){
                        $checked='checked';
                        $active='active focus';
                    }
                    $html.='<label class="btnCriteria btn btn-primary '.$active.'" ';
                    $html.=' idAlumno="'.$idAlumno.'" ';
                    $html.=' idHorario="'.$idHorario.'" ';
                    $html.=' idIndicador="'.$indicador['ID_INDICADOR'].'" ';
                    $html.=' idCategoria="'.$descripcion['ID_CATEGORIA'].'" ';
                    $html.=' idResultado="'.$idResultado.'" ';
                    $html.=' idDescripcion="'.$descripcion['ID_DESCRIPCION'].'" ';
                    $html.=' escalaCalif="'.$descripcion['VALORIZACION'].'" ';
                   $html.=' onclick="new PNotify({
                              title:'."'".'Condición para '. $indicador['ID_INDICADOR'].'-'.$descripcion['VALORIZACION']."'".',
                              text: '."'".$descripcion['NOMBRE_DESCRIPCION']."'".',
                              type: '."'".'info'."'".',
                              styling: '."'".'bootstrap3'."'".'});"';

                          $html.='><input type="radio" class="sr-only" id="viewMode'.$descripcion['ID_DESCRIPCION'].'-'.$idAlumno.'" name="viewMode" value="'.$descripcion['VALORIZACION'].'"'.$checked.'>
                          <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">'.$descripcion['VALORIZACION'].'</span></label>';

                      }
                      $html.='</div></div></div></div></div>';
                  }
                  $html.='</div>';

                  $if_previous_disable = '';
                  $if_next_disable = '';
                  $idPrevious = '';
                  $nombrePrevious = 'Anterior';
                  $idNext = '';
                  $nombreNext = 'Siguiente';
                  if($previous==NULL)              
                    $if_previous_disable = 'disabled';
                else{
                    $idPrevious = $previous->ID_RESULTADO;
                    $nombrePrevious='Resultado '.$previous->NOMBRE;

                }

                if($next == NULL)            
                 $if_next_disable = 'disabled';
             else{
                 $idNext = $next->ID_RESULTADO;
                 $nombreNext='Resultado '.$next->NOMBRE;
             }
             $html .= '
             <br /><br />
             <div align="center">
             <button type="button" name="previous" class="btn btn-warning btn-sm previous" idCurso="'.$idCurso.'" idHorario="'.$idHorario.'" idAlumno="'.$idAlumno.'" id="'.$idPrevious.'" '.$if_previous_disable.'>'.$nombrePrevious.'</button>
             <button type="button" name="next" class="btn btn-warning btn-sm next" idCurso="'.$idCurso.'" idHorario="'.$idHorario.'" idAlumno="'.$idAlumno.'" id="'.$idNext.'" '.$if_next_disable.'>'.$nombreNext.'</button>
             </div>
             <br /><br />
             ';
         }
         return $html;

     }
     public function calificarAlumnos(Request $request){
        $alumno=new eAlumno();
        
        if($alumno->calificarAlumnos($request->all(),Auth::id())){
            flash('Se registró la nota correctamente')->success();
        } else {
            flash('Hubo un error')->error();
        }
        return back();
     }

 }
