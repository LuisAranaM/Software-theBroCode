<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use DB;
use Log;
use Jenssegers\Date\Date as Carbon;


/**
 * Class So
 * 
 * @property int $ID_SOS
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_SEMESTRE
 * @property string $DESCRIPCION
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Especialidade $especialidade
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $eos
 *
 * @package App\Models
 */
class Sos extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
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

	public function especialidad()
	{
		return $this->belongsTo(\App\Models\Especialidad::class, 'ID_ESPECIALIDAD');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'ID_SEMESTRE');
	}

	public function eos()
	{
		return $this->belongsToMany(\App\Models\Eo::class, 'sos_has_eos', 'ID_SOS', 'ID_EOS')
					->withPivot('ID_ESPECIALIDAD', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

	static function getObjetivosEstudiante($idSemestre,$idEspecialidad){
		$objetivosEstudiante = DB::table('SOS')
								->select()
								->where('ID_SEMESTRE','=',$idSemestre)
								->where('ID_ESPECIALIDAD','=',$idEspecialidad)
								->where('ESTADO','=',1);
		return $objetivosEstudiante;
	}
}
