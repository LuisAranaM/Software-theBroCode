<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Semestre
 * 
 * @property int $ID_SEMESTRE
 * @property \Carbon\Carbon $FECHA_INICIO
 * @property \Carbon\Carbon $FECHA_FIN
 * @property \Carbon\Carbon $FECHA_ALERTA
 * @property int $ANHO
 * @property int $CICLO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \Illuminate\Database\Eloquent\Collection $actas
 * @property \Illuminate\Database\Eloquent\Collection $alumnos_has_horarios
 * @property \Illuminate\Database\Eloquent\Collection $criterios
 * @property \Illuminate\Database\Eloquent\Collection $cursos
 * @property \Illuminate\Database\Eloquent\Collection $eos
 * @property \Illuminate\Database\Eloquent\Collection $horarios
 * @property \Illuminate\Database\Eloquent\Collection $planes_de_mejoras
 * @property \Illuminate\Database\Eloquent\Collection $sos
 * @property \Illuminate\Database\Eloquent\Collection $subcriterios_has_alumnos_has_horarios
 *
 * @package App\Models
 */
class Semestre extends Eloquent
{
	protected $primaryKey = 'ID_SEMESTRE';
	public $timestamps = false;

	protected $casts = [
		'ANHO' => 'int',
		'CICLO' => 'int',
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_INICIO',
		'FECHA_FIN',
		'FECHA_ALERTA',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION'
	];

	protected $fillable = [
		'FECHA_INICIO',
		'FECHA_FIN',
		'FECHA_ALERTA',
		'ANHO',
		'CICLO',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

	public function actas()
	{
		return $this->hasMany(\App\Models\Acta::class, 'ID_SEMESTRE', 'id_semestre');
	}

	public function alumnos_has_horarios()
	{
		return $this->hasMany(\App\Models\AlumnosHasHorario::class, 'semestres_ID_SEMESTRE');
	}

	public function criterios()
	{
		return $this->hasMany(\App\Models\Criterio::class, 'ID_SEMESTRE', 'id_semestre');
	}

	public function cursos()
	{
		return $this->hasMany(\App\Models\Curso::class, 'semestres_ID_SEMESTRE');
	}

	public function eos()
	{
		return $this->hasMany(\App\Models\Eo::class, 'ID_SEMESTRE', 'id_semestre');
	}

	public function horarios()
	{
		return $this->hasMany(\App\Models\Horario::class, 'semestres_ID_SEMESTRE');
	}

	public function planes_de_mejoras()
	{
		return $this->hasMany(\App\Models\PlanesDeMejora::class, 'ID_SEMESTRE', 'id_semestre');
	}

	public function sos()
	{
		return $this->hasMany(\App\Models\So::class, 'ID_SEMESTRE');
	}

	public function subcriterios_has_alumnos_has_horarios()
	{
		return $this->hasMany(\App\Models\SubcriteriosHasAlumnosHasHorario::class, 'semestres_ID_SEMESTRE');
	}

	/*static function getCiclo($idSemestre){
		$sql=DB::table('SEMESTRES')
				->select('*',DB::Raw('ANHO'+'-'+'CICLO'))
				->where('ID_SEMESTRE','=',$idSemestre);
		dd($sql->get());
		return $sql;
	}*/

}
