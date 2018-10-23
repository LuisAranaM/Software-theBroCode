<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AlumnosHasHorario
 * 
 * @property int $ID_ALUMNO
 * @property int $ID_HORARIO
 * @property int $ID_PROYECTO
 * @property int $semestres_ID_SEMESTRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Alumno $alumno
 * @property \App\Models\Horario $horario
 * @property \App\Models\Proyecto $proyecto
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $subcriterios
 *
 * @package App\Models
 */
class AlumnosHasHorario extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_ALUMNO' => 'int',
		'ID_HORARIO' => 'int',
		'ID_PROYECTO' => 'int',
		'semestres_ID_SEMESTRE' => 'int',
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION'
	];

	protected $fillable = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

	public function alumno()
	{
		return $this->belongsTo(\App\Models\Alumno::class, 'ID_ALUMNO');
	}

	public function horario()
	{
		return $this->belongsTo(\App\Models\Horario::class, 'ID_HORARIO', 'id_horario');
	}

	public function proyecto()
	{
		return $this->belongsTo(\App\Models\Proyecto::class, 'ID_PROYECTO', 'id_proyecto');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'semestres_ID_SEMESTRE');
	}

	public function subcriterios()
	{
		return $this->belongsToMany(\App\Models\Subcriterio::class, 'subcriterios_has_alumnos_has_horarios', 'ID_ALUMNO', 'ID_SUBCRITERIO')
					->withPivot('ID_RESULTADO', 'ID_ESPECIALIDAD', 'ID_SEMESTRE', 'ID_HORARIO', 'ID_ESCALA', 'semestres_ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}


	static public function geAlumnosByIdHorario($idHorario){
		$ans = DB::table('ALUMNOS_HAS_HORARIOS')
            ->join('ALUMNOS', 'ALUMNOS.ID_ALUMNO', '=', 'ALUMNOS_HAS_HORARIOS.ID_ALUMNO')
            ->select('ALUMNOS.*')
            ->where('ALUMNOS_HAS_HORARIOS.ID_HORARIO','=',$idHorario)
            ->get()->toArray();
        return $ans;
	}

}
