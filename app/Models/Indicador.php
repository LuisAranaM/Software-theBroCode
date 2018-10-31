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
 * Class Subcriterio
 * 
 * @property int $ID_SUBCRITERIO
 * @property int $ID_RESULTADO
 * @property int $ID_ESPECIALIDAD
 * @property int $ID_SEMESTRE
 * @property string $NOMBRE
 * @property string $DESCRIPCION_1
 * @property string $DESCRIPCION_2
 * @property string $DESCRIPCION_3
 * @property string $DESCRIPCION_4
 * @property \Carbon\Carbon $FECHA_REGISTRO
 * @property \Carbon\Carbon $FECHA_ACTUALIZACON
 * @property int $USUARIO_MODIF
 * @property int $ESTADO
 * 
 * @property \App\Models\Criterio $criterio
 * @property \Illuminate\Database\Eloquent\Collection $alumnos_has_horarios
 * @property \Illuminate\Database\Eloquent\Collection $cursos
 *
 * @package App\Models
 */
class Indicador extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'ID_CATEGORIA' => 'int',
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
		'USUARIO_MODIF' => 'int',
		'ESTADO' => 'int'
	];

	protected $dates = [
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACON'
	];

	protected $fillable = [
		'NOMBRE',
		'DESCRIPCION_1',
		'DESCRIPCION_2',
		'DESCRIPCION_3',
		'DESCRIPCION_4',
		'FECHA_REGISTRO',
		'FECHA_ACTUALIZACON',
		'USUARIO_MODIF',
		'ESTADO'
	];

	public function criterio()
	{
		return $this->belongsTo(\App\Models\Criterio::class, 'ID_RESULTADO')
					->where('criterio.ID_RESULTADO', '=', 'subcriterios.ID_RESULTADO')
					->where('criterio.ID_ESPECIALIDAD', '=', 'subcriterios.ID_ESPECIALIDAD')
					->where('criterio.ID_SEMESTRE', '=', 'subcriterios.ID_SEMESTRE');
	}

	public function alumnos_has_horarios()
	{
		return $this->belongsToMany(\App\Models\AlumnosHasHorario::class, 'subcriterios_has_alumnos_has_horarios', 'ID_SUBCRITERIO', 'ID_ALUMNO')
					->withPivot('ID_CRITERIO', 'ID_ESPECIALIDAD', 'ID_SEMESTRE', 'ID_HORARIO', 'ID_ESCALA', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}

	public function cursos()
	{
		return $this->belongsToMany(\App\Models\Curso::class, 'indicadores_has_cursos', 'ID_SUBCRITERIO', 'ID_CURSO')
					->withPivot('ID_RESULTADO', 'ID_ESPECIALIDAD', 'ID_SEMESTRE', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'USUARIO_MODIF', 'ESTADO');
	}


	static function getIndicadoresId($idCat) {
        $sql = DB::table('INDICADORES')
                ->join('CATEGORIAS', 'INDICADORES.ID_CATEGORIA', '=', 'CATEGORIAS.ID_CATEGORIA')
                ->select('INDICADORES.*','CATEGORIAS.ID_CATEGORIA')
                ->where('INDICADORES.ID_CATEGORIA', '=', $idCat)
                ->where('INDICADORES.ESTADO','=', 1);
        //dd($sql->get());
        return $sql;
    }

    static function getIndicador() {
        $sql = DB::table('INDICADORES')
                ->join('CATEGORIAS', 'INDICADORES.ID_CATEGORIA', '=', 'CATEGORIAS.ID_CATEGORIA')
                ->select('INDICADORES.*','CATEGORIAS.ID_CATEGORIA')
                ->where('INDICADORES.ESTADO','=', 1);

        //dd($sql->get());
        return $sql;
    }

	static function getIndicadores($idSem,$idEsp) {
		$sql = DB::table('INDICADORES')
				->leftJoin('CATEGORIAS', 'INDICADORES.ID_CATEGORIA', '=', 'CATEGORIAS.ID_CATEGORIA')
				->leftJoin('RESULTADOS', 'RESULTADOS.ID_RESULTADO', '=', 'CATEGORIAS.ID_RESULTADO')
				->select('RESULTADOS.ID_RESULTADO', 'RESULTADOS.NOMBRE','INDICADORES.ID_INDICADOR','INDICADORES.NOMBRE')
				->where('RESULTADOS.ID_SEMESTRE', '=', $idSem)
				->where('RESULTADOS.ID_ESPECIALIDAD', '=', $idEsp)
				->distinct();
        return $sql;
    }
	public function insertIndicador($idCat,$nombre,$idSem,$idEsp){

		DB::beginTransaction();
        $id=-1;
        try {
        	$id = DB::table('INDICADORES')->insertGetId(
		    	['ID_CATEGORIA' => $idCat,
		     	 'NOMBRE' => $nombre,
		     	 'ID_SEMESTRE'=> $idSem,
		     	 'ID_ESPECIALIDAD'=>$idEsp,
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
	static function getIndicadorId($idInd){
		$sql = DB::table('INDICADORES')
                ->select('*')
                ->where('ID_INDICADOR', '=', $idInd);
        //dd($sql->get());
        return $sql;
    }
    static function updateIndicador($id, $nombre){
		DB::beginTransaction();
        try {
            DB::table('INDICADORES')->where('ID_INDICADOR',$id)
            	->update(
		    	['NOMBRE' => $nombre,
		     	'FECHA_ACTUALIZACION' => Carbon::now(),		
		     	'USUARIO_MODIF' => Auth::id()]);
			DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            DB::rollback();
        }	
    }
    static function deleteIndicador($id){
    	DB::beginTransaction();
        try {
            DB::table('INDICADORES')->where('ID_INDICADOR',$id)
            	->update(
		    	['ESTADO' => 0]);
			DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            DB::rollback();
        }	
    }

}
