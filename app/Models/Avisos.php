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
class Avisos extends Eloquent
{
	static function getAvisos($idSem,$idEsp) {
		//dd($idSem);
        $sql = DB::table('AVISOS')
                ->select('DESCRIPCION', 'FECHA_INICIO', 'FECHA_FIN')
                ->where('ESTADO','=',1)
                ->where('ID_SEMESTRE','=',$idSem)
             	->where('ID_ESPECIALIDAD','=',$idEsp);
        //dd($sql->get());
        return $sql;

	}

	public function insertAviso($id, $desc,$fechaIni,$fechaFin, $idSem, $idEsp){
		DB::beginTransaction();
        $id=-1;
        try {
            $id = DB::table('RESULTADOS')->insertGetId(
		    	['ID_AVISO' => $id,
		     	'DESCRIPCION' => $desc,
		     	'FECHA_INICIO' => $fechaIni,
		     	'FECHA_FIN' => $fechaFin,
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
	
}
