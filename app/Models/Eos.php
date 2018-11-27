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
 * Class Eo
 * 
 * @property int $ID_EOS
 * @property int $ID_SEMESTRE
 * @property int $ID_ESPECIALIDAD
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Especialidade $especialidade
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $sos
 *
 * @package App\Models
 */
class Eos extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'ID_SEMESTRE' => 'int',
		'ID_ESPECIALIDAD' => 'int',
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
		return $this->belongsTo(\App\Models\Especialidad::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'ID_SEMESTRE', 'id_semestre');
	}

	public function sos()
	{
		return $this->belongsToMany(\App\Models\Sos::class, 'sos_has_eos', 'ID_EOS', 'ID_SOS')
					->withPivot('ID_ESPECIALIDAD', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

	static function getObjetivosEducacionales($idSemestre,$idEspecialidad){
		$objetivosEducacionales = DB::table('EOS')
								->select()
								->where('ID_SEMESTRE','=',$idSemestre)
								->where('ID_ESPECIALIDAD','=',$idEspecialidad)
								->where('ESTADO','=',1);
		return $objetivosEducacionales;
	}


	function eliminarEos($registro){
        //dd($registro);    
		DB::beginTransaction();
		$status = true;

		try {
			DB::table('EOS')
			->where('ID_EOS','=',$registro['ID_EOS'])
			->where('NOMBRE','=',$registro['NOMBREEOS'])
			->where('ID_SEMESTRE','=',$registro['ID_SEMESTRE'])
			->where('ID_ESPECIALIDAD','=',$registro['ID_ESPECIALIDAD'])
			->update(['ESTADO'=>0,'FECHA_ACTUALIZACION'=>$registro['FECHA_ACTUALIZACION']]);

			DB::commit();
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			$status = false;
			DB::rollback();
		}
        //dd($status);
		return $status;
        //dd($sql->get());
	}


	function editarEos($registro){
        //dd($registro);    
		DB::beginTransaction();
		$status = true;
		//dd($registro);
		try {
			DB::table('EOS')
			->where('ID_EOS','=',$registro['ID_EOS'])
			->where('ID_SEMESTRE','=',$registro['ID_SEMESTRE'])
			->where('ID_ESPECIALIDAD','=',$registro['ID_ESPECIALIDAD'])
			->update(['NOMBRE'=>$registro['NOMBRE'],'FECHA_ACTUALIZACION'=>$registro['FECHA_ACTUALIZACION']]);

			DB::commit();
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			$status = false;
			DB::rollback();
		}
        //dd($status);
		return $status;
        //dd($sql->get());
	}

	function agregarEos($registro){
        //dd($registro);    
		DB::beginTransaction();
		$status = true;

		try {
			DB::table('EOS')
			->insert(['NOMBRE'=>$registro['NOMBRESEOS'],'ID_SEMESTRE'=>$registro['ID_SEMESTRE'],'ID_ESPECIALIDAD'=>$registro['ID_ESPECIALIDAD'],'FECHA_REGISTRO'=>$registro['FECHA_REGISTRO'],'FECHA_ACTUALIZACION'=>$registro['FECHA_ACTUALIZACION'],'USUARIO_MODIF'=>$registro['USUARIO_MODIF'],'ESTADO'=>$registro['ESTADO']]);

			DB::commit();
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			$status = false;
			DB::rollback();
		}
        //dd($status);
		return $status;
        //dd($sql->get());
	}

}
