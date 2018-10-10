<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Alumno as mAlumno;
use Jenssegers\Date\Date as Carbon;

class Alumno extends \App\Entity\Base\Entity {

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


    
}