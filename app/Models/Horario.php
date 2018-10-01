<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Horario
 * 
 * @property int $ID_HORARIO
 * @property int $ID_CURSO
 * @property int $ID_ESPECIALIDAD
 * @property int $semestres_ID_SEMESTRE
 * @property string $NOMBRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Curso $curso
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $alumnos
 * @property \Illuminate\Database\Eloquent\Collection $profesores_has_horarios
 *
 * @package App\Models
 */
class Horario extends Eloquent
{
	protected $table = 'horario';
	public $timestamps = false;

	protected $casts = [
		'ID_CURSO' => 'int',
		'ID_ESPECIALIDAD' => 'int',
		'semestres_ID_SEMESTRE' => 'int',
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION'
	];

	protected $fillable = [
		'NOMBRE',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

	public function curso()
	{
		return $this->belongsTo(\App\Models\Curso::class, 'ID_CURSO')
					->where('cursos.ID_CURSO', '=', 'horario.ID_CURSO')
					->where('cursos.ID_ESPECIALIDAD', '=', 'horario.ID_ESPECIALIDAD');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'semestres_ID_SEMESTRE');
	}

	public function alumnos()
	{
		return $this->belongsToMany(\App\Models\Alumno::class, 'alumnos_has_horarios', 'ID_HORARIO', 'ID_ALUMNO')
					->withPivot('ID_PROYECTO', 'semestres_ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

	public function profesores_has_horarios()
	{
		return $this->hasMany(\App\Models\ProfesoresHasHorario::class, 'ID_HORARIO');
	}
}
