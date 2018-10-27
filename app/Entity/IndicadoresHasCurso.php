<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\IndicadoresHasCurso as mIndicadoresHasCurso;
use Jenssegers\Date\Date as Carbon;

class IndicadoresHasCurso extends \App\Entity\Base\Entity {

	protected $_fechaRegistro;
    
    function setProperties($data) {
        $this->setValues([
            '_fechaRegistro' => $data->FECHA_REGISTRO,
        ]);
    }

    function setValueToTable() {
        return $this->cleanArray([
            'FECHA_REGISTRO' => $this->_fechaRegistro,
        ]);
    }

    static function getIndicadoresbyIdCurso($idCurso) {
        $model = new mIndicadoresHasCurso();
        return mIndicadoresHasCurso::getIndicadoresbyIdCurso($idCurso,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }


    
}