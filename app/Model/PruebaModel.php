<?php

namespace App\Model;

use DB;
use Log;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date as Carbon;
class PruebaModel extends Model {

    static function getCursos() {
        $sql = DB::table('CURSOS AS CURSOS')
                ->select('ID_CURSO', 'NOMBRE', 'CODIGO_CURSO');
        //dd($sql->get());
        return $sql;
    }

	static function getHorarios($idCurso) {
		//dd($idCurso);
        $sql = DB::table('HORARIO AS H')
				->select('H.ID_HORARIO', 'P.ID_USUARIO', 'H.NOMBRE AS NOMBRE_HORARIO', DB::Raw('CONCAT(P.NOMBRES, " " , P.APELLIDO_PATERNO) AS NOMBRE_PROFESOR'))
                ->leftJoin('PROFESORES_HAS_HORARIOS AS PH', function ($join) {
					$join->on('H.ID_HORARIO', '=', 'PH.ID_HORARIO');
				})
				->leftJoin('USUARIOS AS P', function ($join) {
					$join->on('PH.ID_USUARIO', '=', 'P.ID_USUARIO');
				})
				->where('H.ID_CURSO', '=', $idCurso)
				;

        //dd($sql->get());
        return $sql;
    }
	
    
	
}
