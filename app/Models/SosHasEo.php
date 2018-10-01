<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SosHasEo
 * 
 * @property int $ID_SOS
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_SEMESTRE
 * @property int $ID_EOS
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Eo $eo
 * @property \App\Models\So $so
 *
 * @package App\Models
 */
class SosHasEo extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_SOS' => 'int',
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
		'ID_EOS' => 'int',
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

	public function eo()
	{
		return $this->belongsTo(\App\Models\Eo::class, 'ID_EOS');
	}

	public function so()
	{
		return $this->belongsTo(\App\Models\So::class, 'ID_SOS')
					->where('sos.ID_SOS', '=', 'sos_has_eos.ID_SOS')
					->where('sos.ID_ESPECIALIDAD', '=', 'sos_has_eos.ID_ESPECIALIDAD')
					->where('sos.ID_SEMESTRE', '=', 'sos_has_eos.ID_SEMESTRE');
	}
}
