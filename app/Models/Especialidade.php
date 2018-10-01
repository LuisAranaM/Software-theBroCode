<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Especialidade
 * 
 * @property int $ID_ESPECIALIDAD
 * @property string $NOMBRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \Illuminate\Database\Eloquent\Collection $actas
 * @property \Illuminate\Database\Eloquent\Collection $criterios
 * @property \Illuminate\Database\Eloquent\Collection $cursos
 * @property \Illuminate\Database\Eloquent\Collection $eos
 * @property \Illuminate\Database\Eloquent\Collection $especialidades_has_profesores
 * @property \Illuminate\Database\Eloquent\Collection $planes_de_mejoras
 * @property \Illuminate\Database\Eloquent\Collection $sos
 *
 * @package App\Models
 */
class Especialidade extends Eloquent
{
	protected $primaryKey = 'ID_ESPECIALIDAD';
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
		'NOMBRE',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'USUARIO_MODIF',
		'ESTADO'
	];

	public function actas()
	{
		return $this->hasMany(\App\Models\Acta::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function criterios()
	{
		return $this->hasMany(\App\Models\Criterio::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function cursos()
	{
		return $this->hasMany(\App\Models\Curso::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function eos()
	{
		return $this->hasMany(\App\Models\Eo::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function especialidades_has_profesores()
	{
		return $this->hasMany(\App\Models\EspecialidadesHasProfesore::class, 'ID_ESPECIALIDAD');
	}

	public function planes_de_mejoras()
	{
		return $this->hasMany(\App\Models\PlanesDeMejora::class, 'ID_ESPECIALIDAD');
	}

	public function sos()
	{
		return $this->hasMany(\App\Models\So::class, 'ID_ESPECIALIDAD');
	}
}
