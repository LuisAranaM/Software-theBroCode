<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Jenssegers\Date\Date as Carbon;

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
		return $this->hasMany(\App\Models\AlumnosHasHorario::class, 'ID_SEMESTRE');
	}

	/*public function criterios()
	{
		return $this->hasMany(\App\Models\Criterio::class, 'ID_SEMESTRE', 'id_semestre');
	}*/

	public function cursos()
	{
		return $this->hasMany(\App\Models\Curso::class, 'ID_SEMESTRE');
	}

	public function eos()
	{
		return $this->hasMany(\App\Models\Eo::class, 'ID_SEMESTRE', 'id_semestre');
	}

	public function horarios()
	{
		return $this->hasMany(\App\Models\Horario::class, 'ID_SEMESTRE');
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
		return $this->hasMany(\App\Models\SubcriteriosHasAlumnosHasHorario::class, 'ID_SEMESTRE');
	}


	static function getCiclo($idSemestre){
		$sql=DB::table('SEMESTRES')
		->select('*',DB::raw('CONCAT(ANHO, "-", CICLO) AS SEMESTRE'))
		->where('ID_SEMESTRE','=',$idSemestre);
		return $sql;
	}

	static function getSemestres($tipo=null,$idSemestreActual=null,$vistaResultado=null){
		$sql=DB::table('SEMESTRES')
		->select('ID_SEMESTRE',DB::Raw("CONVERT(FECHA_INICIO,DATE) AS FECHA_INICIO"),
			DB::Raw("CONVERT(FECHA_FIN,DATE) AS FECHA_FIN"),
			DB::Raw("CONVERT(FECHA_ALERTA,DATE) AS FECHA_ALERTA"),
			DB::raw('CONCAT(ANHO, "-", CICLO) AS SEMESTRE'),'ANHO','CICLO')
				//->where('ESTADO','>=',1)
		->orderBy('ANHO','DESC')
		->orderBy('CICLO','DESC');

		$anho=self::getCiclo($idSemestreActual)->first()->ANHO;
		$ciclo=self::getCiclo($idSemestreActual)->first()->CICLO;
		if($tipo)
			$sql=$sql->where('ESTADO','<>',0);
		else{
			$sql=$sql->where('ESTADO','>=',1);

			if($ciclo==1)
				$sql=$sql->where('ANHO','<=',$anho)
			->where(DB::Raw('CONCAT(ANHO,CICLO)'),'<>',$anho.'2');
			else if ($ciclo==2)
				$sql=$sql->where('ANHO','<=',$anho);

			if($vistaResultado){
				$sql=$sql->where(DB::Raw('CONCAT(ANHO,CICLO)'),'<>',$anho.$ciclo);
			}
		}

					//->where();
		

		return $sql;
	}

	static function getIdSemestre(){
		$sql=DB::table('SEMESTRES')
		->select('ID_SEMESTRE')
		->where('ESTADO','=',2);
		if($sql->count()==0) return null;
		return $sql->first()->ID_SEMESTRE;
	}

	function actualizarSemestreSistema($idSemestre,$idUsuario){
		//dd(Carbon::now());    
		DB::beginTransaction();
		$status = true;

		try {

			DB::table('SEMESTRES')                
			->where('ESTADO','=',2)
			->update(['ESTADO'=>1,
				'FECHA_ACTUALIZACION'=>Carbon::now(),
				'USUARIO_MODIF'=>$idUsuario]);

			DB::table('SEMESTRES')                
			->where('ID_SEMESTRE','=',$idSemestre)
			->update(['ESTADO'=>2,
				'FECHA_ACTUALIZACION'=>Carbon::now(),
				'USUARIO_MODIF'=>$idUsuario]);

			DB::commit();
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			$status = false;
			DB::rollback();
		}
		return $status;
        //dd($sql->get());
	}

	public function crearSemestre($semestre){
		DB::beginTransaction();
		$id=-1;
		try {
			$id = DB::table('SEMESTRES')->insertGetId($semestre);
			DB::commit();
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			DB::rollback();
		}
		return $id;
	}

	public function editarSemestre($semestre){
		DB::beginTransaction();
		$id=1;
		try {
			DB::table('SEMESTRES')
			->where('ID_SEMESTRE','=',$semestre['ID_SEMESTRE'])
			->update(['FECHA_INICIO'=> $semestre['FECHA_INICIO'],  
				'FECHA_FIN'=> $semestre['FECHA_FIN'],  
				'FECHA_ALERTA'=> $semestre['FECHA_ALERTA'] ,  
				'ANHO'=> $semestre['ANHO'] ,  
				'CICLO'=> $semestre['CICLO'] ,  
				'FECHA_ACTUALIZACION'=>$semestre['FECHA_ACTUALIZACION'],
				'USUARIO_MODIF'=>$semestre['USUARIO_MODIF']]);
			DB::commit();
		} catch (\Exception $e) {
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			DB::rollback();
		}
		return $id;
	}

	static function verificarSemestre($semestre,$flgEditar=null){
		$sql=DB::table('SEMESTRES')
		->select()
		->where('ANHO','=',$semestre['ANHO'])
		->where('CICLO','=',$semestre['CICLO'])
		->where('ESTADO','<>',0);

		if($flgEditar)
			$sql=$sql->where('ID_SEMESTRE','<>',$semestre['ID_SEMESTRE']);

		return $sql->count();
	}

	public function eliminarSemestre($idSemestre,$idUsuario){
		DB::beginTransaction();
		$id=1;
		try {
			DB::table('SEMESTRES')
			->where('ID_SEMESTRE','=',$idSemestre)
			->update(['ESTADO'=>0,
				'FECHA_ACTUALIZACION'=>Carbon::now(),
				'USUARIO_MODIF'=>$idUsuario]);
			DB::commit();
		} catch (\Exception $e) {
			$id=0;
			Log::error('BASE_DE_DATOS|' . $e->getMessage());
			DB::rollback();
		}
		return $id;
	}

}
