<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Usuario
 * 
 * @property int $ID_USUARIO
 * @property int $ID_ROL
 * @property string $USUARIO
 * @property string $PASS
 * @property string $CORREO
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * @property string $NOMBRES
 * @property string $APELLIDO_PATERNO
 * @property string $APELLIDO_MATERNO
 * 
 * @property \App\Models\Role $role
 * @property \Illuminate\Database\Eloquent\Collection $especialidades_has_profesores
 * @property \Illuminate\Database\Eloquent\Collection $profesores_has_horarios
 *
 * @package App\Models
 */
class Usuario extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'ID_ROL' => 'int',
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION'
	];

	protected $fillable = [
		'USUARIO',
		'PASS',
		'CORREO',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACION',
		'USUARIO_MODIF',
		'ESTADO',
		'NOMBRES',
		'APELLIDO_PATERNO',
		'APELLIDO_MATERNO'
	];

	public function role()
	{
		return $this->belongsTo(\App\Models\Role::class, 'ID_ROL');
	}

	public function especialidades_has_profesores()
	{
		return $this->hasMany(\App\Models\EspecialidadesHasProfesore::class, 'ID_USUARIO', 'id_usuario');
	}

	public function profesores_has_horarios()
	{
		return $this->hasMany(\App\Models\ProfesoresHasHorario::class, 'ID_USUARIO', 'id_usuario');
	}
}
