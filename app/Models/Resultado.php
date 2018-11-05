<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Reliese\Database\Eloquent\Model as Eloquent;
use Jenssegers\Date\Date as Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as Log;

/**
 * Class Criterio
 * 
 * @property int $ID_RESULTADO
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_SEMESTRE
 * @property string $NOMBRE
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACION
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Especialidade $especialidade
 * @property \App\Models\Semestre $semestre
 * @property \Illuminate\Database\Eloquent\Collection $subcriterios
 *
 * @package App\Models
 */
class Resultado extends Eloquent
{
	protected $table = 'resultados';
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

	static function getResultados($idSem,$idEsp) {
		//dd($idSem);
        $sql = DB::table('RESULTADOS')
                ->select('ID_RESULTADO', 'NOMBRE', 'DESCRIPCION')
                ->where('ESTADO','=',1)
                ->where('ID_SEMESTRE','=',$idSem)
             	->where('ID_ESPECIALIDAD','=',$idEsp);
        //dd($sql->get());
        return $sql;

	}
	
	static function getResultadosbyIdCurso($idCurso,$idSem,$idEsp) {
		//dd($idCurso,$idSem,$idEsp);
		$sql = DB::table('INDICADORES_HAS_CURSOS')
				->where('INDICADORES_HAS_CURSOS.ID_CURSO','=',$idCurso)
				->leftJoin('RESULTADOS', 'RESULTADOS.ID_RESULTADO', '=', 'INDICADORES_HAS_CURSOS.ID_RESULTADO')
				->select('RESULTADOS.ID_RESULTADO', 'RESULTADOS.NOMBRE')
				->where('RESULTADOS.ID_SEMESTRE','=',$idSem)
				->where('RESULTADOS.ID_ESPECIALIDAD','=',$idEsp)
				->where('INDICADORES_HAS_CURSOS.ESTADO','=',1)
				->distinct();
        //dd($sql->get());
        return $sql;
	}
	


	public function insertResultado($nombre, $desc,$idSem,$idEsp){
		DB::beginTransaction();
        $id=-1;
        try {
            $id = DB::table('RESULTADOS')->insertGetId(
		    	['NOMBRE' => $nombre,
		     	'DESCRIPCION' => $desc,
		     	'ID_SEMESTRE' => $idSem,
		     	'ID_ESPECIALIDAD' => $idEsp,
		     	'FECHA_REGISTRO' => Carbon::now(),
		     	'FECHA_ACTUALIZACION' => Carbon::now(),		
		     	'USUARIO_MODIF' => Auth::id(),     	
				 'ESTADO' => 1]);
			DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            DB::rollback();
        }	

		return $id;
	}
	static function updateResultado($id, $nombre, $desc){
		DB::beginTransaction();
        try {
            DB::table('RESULTADOS')->where('ID_RESULTADO',$id)
            	->update(
		    	['NOMBRE' => $nombre,
		     	'DESCRIPCION' => $desc,
		     	'FECHA_ACTUALIZACION' => Carbon::now(),		
		     	'USUARIO_MODIF' => Auth::id()]);
			DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            DB::rollback();
        }	
    }
    static function deleteResultado($id){
    	DB::beginTransaction();
        try {
        	//dd($id);
            DB::table('RESULTADOS')->where('ID_RESULTADO',$id)
            	->update(
		    	['ESTADO' => 0]);
			DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            DB::rollback();
        }	
    }

	public function especialidad()
	{
		return $this->belongsTo(\App\Models\Especialidad::class, 'ID_ESPECIALIDAD', 'id_especialidad');
	}

	public function semestre()
	{
		return $this->belongsTo(\App\Models\Semestre::class, 'ID_SEMESTRE', 'id_semestre');
	}

	public function subcriterios()
	{
		return $this->hasMany(\App\Models\Subcriterio::class, 'ID_RESULTADO');
	}
}
