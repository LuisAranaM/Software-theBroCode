<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\PlanesDeMejora as mPlanesDeMejora;
use Jenssegers\Date\Date as Carbon;

class PlanesDeMejora extends \App\Entity\Base\Entity {

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
    static function buscarDocumentos(){
        return mPlanesDeMejora::buscarDocumentos(self::getEspecialidadUsuario());
    }
    static function resultadosFiltroDocs($anhoInicio,$semIni,$anhoFin,$semFin, $tipo){
        $model =new mPlanesDeMejora();
        return $model->resultadosFiltroDocs($anhoInicio,$semIni,$anhoFin,$semFin, $tipo, self::getEspecialidadUsuario());   
    }
     static function getTipos($tipo=null)
    {
        return mPlanesDeMejora::getTipos();
    }
    
}