<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EscalaCalificacion
 * 
 * @property int $ID_ESCALA
 * @property string $NOMBRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \Illuminate\Database\Eloquent\Collection $subcriterios_has_alumnos_has_horarios
 *
 * @package App\Models
 */
class EscalaCalificacion extends Eloquent
{
	protected $table = 'escala_calificacion';
	protected $primaryKey = 'ID_ESCALA';
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

	public function subcriterios_has_alumnos_has_horarios()
	{
		return $this->hasMany(\App\Models\SubcriteriosHasAlumnosHasHorario::class, 'ID_ESCALA');
	}
}
