<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\IndicadoresHasAlumnosHasHorarios as mIndicadoresHasAlumnosHasHorarios;
use Jenssegers\Date\Date as Carbon;

class IndicadoresHasAlumnosHasHorarios extends \App\Entity\Base\Entity {

    
    static function getValoresReporte1($idInd,$idHorario){
        $model =new mIndicadoresHasAlumnosHasHorarios();
        return $model->getValoresReporte1($idInd,$idHorario,self::getIdSemestre(),self::getEspecialidadUsuario());
    }

}