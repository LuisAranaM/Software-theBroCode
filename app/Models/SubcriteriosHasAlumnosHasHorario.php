<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SubcriteriosHasAlumnosHasHorario
 * 
 * @property int $ID_SUBCRITERIO
 * @property int $ID_RESULTADO
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_SEMESTRE
 * @property int $ID_ALUMNO
 * @property int $ID_HORARIO
 * @property int $ID_ESCALA
 * @property int $semestres_ID_SEMESTRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\AlumnosHasHorario $alumnos_has_horario
 * @property \App\Models\EscalaCalificacion $escala_calificacion
 * @property \App\Models\Subcriterio $subcriterio
 * @property \App\Models\Semestre $semestre
 *
 * @package App\Models
 */
class SubcriteriosHasAlumnosHasHorario extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_SUBCRITERIO' => 'int',
		'ID_RESULTADO' => 'int',
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
		'ID_ALUMNO' => 'int',
		'ID_HORARIO' => 'int',
		'ID_ESCALA' => 'int',
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

	public function alumnos_has_horario()
	{
		return $this->belongsTo(\App\Models\AlumnosHasHorario::class, 'ID_ALUMNO')
					->where('alumnos_has_horarios.ID_ALUMNO', '=', 'subcriterios_has_alumnos_has_horarios.ID_ALUMNO')
					->where('alumnos_has_horarios.ID_HORARIO', '=', 'subcriterios_has_alumnos_has_horarios.ID_HORARIO');
	}

	public function escala_calificacion()
	{
		return $this->belongsTo(\App\Models\EscalaCalificacion::class, 'ID_ESCALA');
	}

	public function subcriterio()
	{
		return $this->belongsTo(\App\Models\Subcriterio::class, 'ID_SUBCRITERIO')
					->where('subcriterios.ID_SUBCRITERIO', '=', 'subcriterios_has_alumnos_has_horarios.ID_SUBCRITERIO')
					->where('subcriterios.ID_RESULTADO', '=', 'subcriterios_has_alumnos_has_horarios.ID_RESULTADO')
					->where('subcriterios.ID_ESPECIALIDAD', '=', 'subcriterios_has_alumnos_has_horarios.ID_ESPECIALIDAD')
					->where('subcriterios.ID_SEMESTRE', '=', 'subcriterios_has_alumnos_has_horarios.ID_SEMESTRE');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'semestres_ID_SEMESTRE');
	}
}
