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

	static function getObjetivosTotales($idSem,$idEsp) {
		//dd($idSem);
		$sql = DB::table('SOS')
		->select('ID_SOS', 'NOMBRE')
		->where('ESTADO','=',1)
		->where('ID_SEMESTRE','=',$idSem)
		->where('ID_ESPECIALIDAD','=',$idEsp);

        //dd($sql->get());
		return $sql;

	}
	static function getinformacionObj($idSemestre,$idEspecialidad){
		/*$sql=DB::table(DB::Raw("(SELECT 
			ID_ESPECIALIDAD,ID_SEMESTRE,
			NOMBRE
			FROM SOS
			WHERE ESTADO=1
			UNION
			SELECT 
			ID_ESPECIALIDAD,ID_SEMESTRE,
			NOMBRE
			FROM EOS
			WHERE ESTADO=1
			

		)"));*/
		$first = DB::table('SOS')
		->select('ID_SOS', 'NOMBRE')
		->where('ESTADO','=',1)
		->where('ID_SEMESTRE','=',$idSemestre)
		->where('ID_ESPECIALIDAD','=',$idEspecialidad);
		
		/*$second= DB::table('EOS')
            ->select('ID_EOS', 'NOMBRE')
			->where('ESTADO','=',1)
			->where('ID_SEMESTRE','=',$idSemestre)
			->where('ID_ESPECIALIDAD','=',$idEspecialidad)
			->union($first)
            ->get();
		*/
		//dd($sql->get());
		return   $first;

		//$equis = "hola";
		//return $equis;
	}

	function eliminarSos($registro){
        //dd($registro);    
		DB::beginTransaction();
		$status = true;

		try {
			DB::table('SOS')
			->where('ID_SOS','=',$registro['ID_SOS'])
			->where('NOMBRE','=',$registro['NOMBRESOS'])
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

	
	function editarSos($registro){
        //dd($registro);    
		DB::beginTransaction();
		$status = true;
		//dd($registro);
		try {
			DB::table('SOS')
			->where('ID_SOS','=',$registro['ID_SOS'])
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

	function agregarSos($registro){
        //dd($registro);    
		DB::beginTransaction();
		$status = true;

		try {
			DB::table('SOS')
			->insert(['NOMBRE'=>$registro['NOMBRESOS'],'ID_SEMESTRE'=>$registro['ID_SEMESTRE'],'ID_ESPECIALIDAD'=>$registro['ID_ESPECIALIDAD'],'FECHA_REGISTRO'=>$registro['FECHA_REGISTRO'],'FECHA_ACTUALIZACION'=>$registro['FECHA_ACTUALIZACION'],'USUARIO_MODIF'=>$registro['USUARIO_MODIF'],'ESTADO'=>$registro['ESTADO']]);

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
