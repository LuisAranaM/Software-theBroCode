<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use DB;
use Log;
use App\Entity\IndicadoresHasCurso as IndicadoresHasCurso;
use App\Entity\Descripcion as Descripcion;
use Reliese\Database\Eloquent\Model as Eloquent;
use Jenssegers\Date\Date as Carbon;

/**
 * Class Curso
 * 
 * @property int $ID_CURSO
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_SEMESTRE
 * @property string $NOMBRE
 * @property string $CODIGO_CURSO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $ESTADO_ACREDITACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Especialidade $especialidade
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $horarios
 * @property \Illuminate\Database\Eloquent\Collection $subcriterios
 *
 * @package App\Models
 */
class Curso extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
		'ESTADO_ACREDITACION' => 'int',
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION'
	];

	protected $fillable = [
		'NOMBRE',
		'CODIGO_CURSO',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'ESTADO_ACREDITACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

	public function especialidad()
	{
		return $this->belongsTo(\App\Models\Especialidad::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'ID_SEMESTRE');
	}

	public function horarios()
	{
		return $this->hasMany(\App\Models\Horario::class, 'ID_CURSO');
	}

	/*public function subcriterios()
	{
		return $this->belongsToMany(\App\Models\Subcriterio::class, 'subcriterios_has_cursos', 'ID_CURSO', 'ID_SUBCRITERIO');
	}*/

  static function trace($cad){
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln("<info>".$cad."</info>");
  }

  static function getCursosYHorarios($idEspecialidad,$idSemestre,$usuario){
    $cursos = DB::table('CURSOS')
                ->select('*')
                ->where('ESTADO_ACREDITACION','=',1)
                ->where('ID_ESPECIALIDAD','=',$idEspecialidad)
                ->where('ID_SEMESTRE','=',$idSemestre)
                ->get();
    
    $ans = array();
    $cantValorizacion = Descripcion::getValorizacionMaxima();

    $horariosProf = DB::table('CURSOS')
                    ->select('*')
                    ->where('ID_SEMESTRE','=',-1)
                    ->get();

    $info = array();
    if($usuario->ID_ROL==4){        
        $horariosProf=Horario::getHorariosProfesor($idSemestre,$idEspecialidad,$usuario->ID_USUARIO);
    }

    foreach($cursos as $c){
      
        $data["curso"] = $c;
        $horarios = Horario::getHorariosCompleto($c->ID_CURSO,$idSemestre); //MODELO
        $cantIndicadores = IndicadoresHasCurso::getCantIndicadoresByCurso($c->ID_CURSO, $idSemestre);
      
        foreach($horarios as $h){
            
        if($usuario->ID_ROL == 4){
            // filtrar cursos
            $esta = false;
            foreach($horariosProf as $x){
                if($h->ID_HORARIO == $x->ID_HORARIO)
                    $esta = true;
            }
            if(!$esta) continue;
        }
        

        $horario["horario"] = $h;
        $results = Horario::getIndicadoresHasAlumnosHasHorarios($h->ID_HORARIO);
        $tot = Horario::getCantAlumnos($h->ID_HORARIO);
        $horario["alumnosTotal"] = $tot;
        $part = 0;
        $idAlumnos = array();
        foreach($results as $x){
            if($x->ESTADO == 0)
                continue;
            $id = $x->ID_ALUMNO;
            $part++;
            $has = false;
            foreach($idAlumnos as $a){
                if($a == $id){
                    $has = true;
                    break;
                }
            }
            if($has == false){
                $idAlumnos[] = $id;
            }
        }
        $tot = $tot * $cantValorizacion * $cantIndicadores;
        $res = 0;
        if($tot != 0) $res = round($part*100/$tot,2);
        $horario["avance"] = $res;
        $res = 0;
        foreach($idAlumnos as $x){
            $cont = 0;
            foreach($results as $y){
                if($y->ID_ALUMNO == $x) $cont++;
            }
            if($cont == $cantValorizacion * $cantIndicadores) $res++;
        }
        $horario["alumnosCalif"] = $res;
        $info[] = $horario;
      }
      $data["horarios"] = $info;
      $info = array();
      $ans[] = $data;
    }
    return $ans;
  }

	static function getCursoByIdHorario($idHorario) {
        $sql = DB::table('CURSOS AS CURSOS')
                ->join('HORARIOS', 'CURSOS.ID_CURSO', '=', 'HORARIOS.ID_CURSO')
                ->select('CURSOS.ID_CURSO', 'CURSOS.NOMBRE', 'CURSOS.CODIGO_CURSO')
                ->where('HORARIOS.ID_HORARIO',(int)$idHorario)
                ->distinct();
        //dd($sql->get());
        return $sql;
    }

  static function getCursos($idSemestre,$idEspecialidad) {
        $sql = DB::table('CURSOS AS CURSOS')
                ->select('ID_CURSO', 'NOMBRE', 'CODIGO_CURSO')
                ->where('ID_SEMESTRE','=',$idSemestre)
                ->where('ID_ESPECIALIDAD','=',$idEspecialidad)
                ->where('ESTADO','=',1)
                ->where('ESTADO_ACREDITACION','=',1)
                ->orderBy('NOMBRE','ASC');

        return $sql;
    }

    static function buscarCursos($idSemestre,$idEspecialidad,$nomCurso=null,$acreditacion=false) {
        $sql = DB::table('CURSOS AS CURSOS')
                ->select('ID_CURSO', 'NOMBRE', 'CODIGO_CURSO','ESTADO_ACREDITACION')
                ->where('ID_SEMESTRE','=',$idSemestre)
                ->where('ID_ESPECIALIDAD','=',$idEspecialidad)
                ->where('ESTADO','=',1)
                ->orderBy('ESTADO_ACREDITACION','DESC')
                ->orderBy('NOMBRE','ASC');
        //dd($acreditacion);
        if($nomCurso)
            $sql=$sql->where('NOMBRE','like','%'.$nomCurso.'%');

        if($acreditacion)
            $sql=$sql->where('ESTADO_ACREDITACION','=',0);
        return $sql;
    }


    function agregarAcreditar($idSemestre,$idEspecialidad,$codigos,$usuario){

        //dd(Carbon::now());    
        DB::beginTransaction();
        $status = true;
       
        try {


            DB::table('CURSOS AS CURSOS')                
                ->where('ID_ESPECIALIDAD','=',$idEspecialidad)
                ->where('ID_SEMESTRE','=',$idSemestre)
                ->update(['ESTADO_ACREDITACION'=>0,
                        'FECHA_ACTUALIZACION'=>Carbon::now(),
                        'USUARIO_MODIF'=>$usuario]);

            DB::table('CURSOS AS CURSOS')
                ->whereIn('CODIGO_CURSO',$codigos)
                ->where('ID_SEMESTRE','=',$idSemestre)
                ->update(['ESTADO_ACREDITACION'=>1,
                        'FECHA_ACTUALIZACION'=>Carbon::now(),
                        'USUARIO_MODIF'=>$usuario]);
            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        return $status;
        //dd($sql->get());
    }

    function eliminarAcreditar($idSemestre,$codigo,$usuario){
        //dd(Carbon::now());    
        DB::beginTransaction();
        $status = true;
       
        try {
            DB::table('CURSOS AS CURSOS')
                ->where('CODIGO_CURSO','=',$codigo)
                ->where('ID_SEMESTRE','=',$idSemestre)
                ->update(['ESTADO_ACREDITACION'=>0,
                        'FECHA_ACTUALIZACION'=>Carbon::now(),
                        'USUARIO_MODIF'=>$usuario]);
            DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            $status = false;
            DB::rollback();
        }
        return $status;
        //dd($sql->get());
    }

    public function getIdCurso($codCurso){
        $sql = DB::table('CURSOS')
                ->select('ID_CURSO')
                ->where('CODIGO_CURSO','=',$codCurso)
                ->where('ESTADO','=',1);
        return $sql;
    }

}

