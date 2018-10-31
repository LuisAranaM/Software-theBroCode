<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Sep 2018 22:12:14 +0000.
 */

namespace App\Models;
use DB;
use Reliese\Database\Eloquent\Model as Eloquent;

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
class Categoria extends Eloquent
{
	protected $table = 'CATEGORIAS';
	public $timestamps = false;

	protected $casts = [
		'ID_ESPECIALIDAD' => 'int',
		'ID_SEMESTRE' => 'int',
		'ID_RESULTADO' => 'int',
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

	public function insertCategoria($categoria, $resultado){
		DB::beginTransaction();
        $id=-1;
        try {
        	$id = DB::table('CATEGORIAS')->insertGetId(
		    	['NOMBRE' => $categoria,
		     	 'ID_RESULTADO' => $resultado,
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
	static function getCategoriasId($idRes) {
        $sql = DB::table('CATEGORIAS')
                ->select('ID_CATEGORIA','ID_RESULTADO', 'NOMBRE')
                ->where('ID_RESULTADO', '=', $idRes)
                ->where('ESTADO','=', 1);
        return $sql;
	}

    static function getCategorias() {
        $sql = DB::table('CATEGORIAS')
                ->select('ID_CATEGORIA','ID_RESULTADO', 'NOMBRE')
                ->where('ESTADO','=', 1);
        return $sql;
    }

	
}
