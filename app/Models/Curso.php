<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use DB;
use Log;
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

  static function getCursosYHorarios($idSemestre){
    $cursos = DB::table('CURSOS')
                ->select('*')
                ->where('ESTADO_ACREDITACION','=',1)
                ->where('ID_SEMESTRE','=',$idSemestre)
                ->get();
    $ans = array();
    foreach($cursos as $c){
      $data["curso"] = $c;
      Curso::trace('IDCURSO');
      Curso::trace($c->ID_CURSO);
      $horarios = Horario::getHorariosCompleto($c->ID_CURSO,$idSemestre); //MODELO
      foreach($horarios as $h){
        Curso::trace('IDHORARIO');
        Curso::trace($h->ID_HORARIO);
        $horario["horario"] = $h;
        $horario["avance"] = Horario::getAvance($h->ID_HORARIO);
        $horario["alumnosCalif"] = Horario::getAlumnosCalif($h->ID_HORARIO);
        $horario["alumnosTotal"] = Horario::getCantAlumnos($h->ID_HORARIO);
        $info[] = $horario;
      }
      $data["horarios"] = $info;
      $info = array();
      $ans[] = $data;
    }

    foreach($ans as $x){
      Curso::trace($x["curso"]->NOMBRE);
      foreach($x["horarios"] as $y){
        Curso::trace($y["horario"]->NOMBRE);
      }
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
    }

}

