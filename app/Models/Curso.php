<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 04 Oct 2018 18:18:52 +0000.
 */

namespace App\Models;
 
use DB;
use Log;
use App\Entity\Horario as Horario;
use Reliese\Database\Eloquent\Model as Eloquent;
use Jenssegers\Date\Date as Carbon;
 
 /**
- * Class Curso
  * 
  * @property int $ID_CURSO
  * @property int $ID_ESPECIALIDAD
  * @property int $semestres_ID_SEMESTRE
  * @property string $NOMBRE
  * @property string $CODIGO_CURSO
  * @property \Carbon\Carbon $FECHA_REGISTRO
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
class Curso extends Eloquent {
 	public $timestamps = false;
 
 	protected $casts = [
 		'ID_ESPECIALIDAD' => 'int',
		'semestres_ID_SEMESTRE' => 'int',
 		'ESTADO_ACREDITACION' => 'int',
 		'USUARIO_MODIF' => 'int',
 		'ESTADO' => 'int'
 	];
 
	public function especialidade()
 	{
		return $this->belongsTo(\App\Models\Especialidade::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'semestres_ID_SEMESTRE');
	}

	public function horarios()
	{
		return $this->hasMany(\App\Models\Horario::class, 'ID_CURSO');
	}

	public function subcriterios()
	{
		return $this->belongsToMany(\App\Models\Subcriterio::class, 'subcriterios_has_cursos', 'ID_CURSO', 'ID_SUBCRITERIO');
	}

  static function trace($cad){
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln("<info>".$cad."</info>");
  }

  static function getCursosYHorarios(){
    $cursos = DB::table('CURSOS')
                ->select('*')
                ->get();
    $ans = array();
    foreach($cursos as $c){
      $data["curso"] = $c;
      $horarios = Horario::getHorarios($c->ID_CURSO);
      foreach($horarios as $h){
        $horario["horario"] = $h;
        $horario["avance"] = Horario::getAvance($h->ID_HORARIO);
        $horario["alumnosCalif"] = Horario::getAlumnosCalif($h->ID_HORARIO);
        $horario["alumnosTotal"] = Horario::getCantAlumnos($h->ID_HORARIO);
        Curso::trace($horario["avance"]);
        Curso::trace($horario["alumnosCalif"]);
        Curso::trace($horario["alumnosTotal"]);
        $horarios[] = $horario;
      }
      $data["horarios"] = $horarios;
      $ans[] = $data;
    }
    return $ans;
  }

	static function getCursos() {
        $sql = DB::table('CURSOS AS CURSOS')
                ->select('ID_CURSO', 'NOMBRE', 'CODIGO_CURSO');
        //dd($sql->get());
        return $sql;
    }

    static function buscarCursos($nomCurso) {
        $sql = DB::table('CURSOS AS CURSOS')
                ->select('ID_CURSO', 'NOMBRE', 'CODIGO_CURSO')
                ->where('NOMBRE','like','%'.$nomCurso.'%');

        //dd($sql->get());
        return $sql;
    }





}




