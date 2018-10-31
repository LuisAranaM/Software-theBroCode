<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Proyecto as mProyecto;
use Jenssegers\Date\Date as Carbon;

class Proyecto extends \App\Entity\Base\Entity {

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
    static function getRutaProyectos($idHorario){
        return mProyecto::getRutaProyectos($idHorario);
    }
    
}