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
 *
 * @package App\Models
 */
class Descripcion extends Eloquent
{
	protected $table = 'DESCRIPCIONES';
	public $timestamps = false;

	protected $casts = [
		'ID_INDICADOR' => 'int',
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

	public function insertDescripcion($descripcion, $indicador){
		DB::beginTransaction();
        $id=-1;
        try {
        	$id = DB::table('DESCRIPCIONES')->insertGetId(
		    	['NOMBRE' => $descripcion,
		     	 'ID_INDICADOR' => $indicador,
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
	static function getDescripcionesId($idInd) {
        $sql = DB::table('DESCRIPCIONES')
                ->select('ID_DESCRIPCION','ID_INDICADOR', 'NOMBRE')
                ->where('ID_INDICADOR', '=', $idInd)
                ->where('ESTADO','=', 1);
        return $sql;
    }

    static function updateDescripcion($id, $nombre){
		DB::beginTransaction();
        try {
            DB::table('DESCRIPCIONES')->where('ID_DESCRIPCION',$id)
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
    static function deleteDescripcion($id){
    	DB::beginTransaction();
        try {
            DB::table('DESCRIPCIONES')->where('ID_DESCRIPCION',$id)
            	->update(
		    	['ESTADO' => 0]);
			DB::commit();
        } catch (\Exception $e) {
            Log::error('BASE_DE_DATOS|' . $e->getMessage());
            DB::rollback();
        }	
    }
	
}
