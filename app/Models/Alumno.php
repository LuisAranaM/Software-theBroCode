<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Alumno
 * 
 * @property int $ID_ALUMNO
 * @property string $NOMBRES
 * @property string $APELLIDO_PATERNO
 * @property string $APELLIDO_MATERNO
 * @property string $CODIGO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \Illuminate\Database\Eloquent\Collection $horarios
 *
 * @package App\Models
 */
class Alumno extends Eloquent
{
	protected $primaryKey = 'ID_ALUMNO';
	public $timestamps = false;

	protected $casts = [
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION'
	];

	protected $fillable = [
		'NOMBRES',
		'APELLIDO_PATERNO',
		'APELLIDO_MATERNO',
		'CODIGO',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

	public function horarios()
	{
		return $this->belongsToMany(\App\Models\Horario::class, 'alumnos_has_horarios', 'ID_ALUMNO', 'ID_HORARIO')
					->withPivot('ID_PROYECTO', 'semestres_ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

<<<<<<< HEAD
	static function getAlumnosByHorarioStatic($idHorario){
		$ans = DB::table('ALUMNOS')
            ->join('ALUMNOS_HAS_HORARIOS', 'ALUMNOS.ID_ALUMNO', '=', 'ALUMNOS_HAS_HORARIOS.ID_ALUMNO')
            ->select('ALUMNOS.*')
            ->where('ALUMNOS_HAS_HORARIOS.ID_HORARIO','=',$idHorario)
            ->get();
        return $ans;
	}

	public function getAlumnosByHorario($idHorario){
		$ans = DB::table('ALUMNOS')
            ->join('ALUMNOS_HAS_HORARIOS', 'ALUMNOS.ID_ALUMNO', '=', 'ALUMNOS_HAS_HORARIOS.ID_ALUMNO')
            ->select('ALUMNOS.*')
            ->where('ALUMNOS_HAS_HORARIOS.ID_HORARIO','=',$idHorario)
            ->get();
        return $ans;
	}

=======
>>>>>>> KarlasBranch
}
