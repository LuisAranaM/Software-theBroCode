<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\SubcriteriosHasCurso as mSubcriteriosHasCurso;
use Jenssegers\Date\Date as Carbon;

class SubcriteriosHasCurso extends \App\Entity\Base\Entity {

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

<<<<<<< HEAD
    static function getSubCriteriosbyIdCurso($idCurso) {
        $model = new mSubcriteriosHasCurso();
        return mSubcriteriosHasCurso::getSubCriteriosbyIdCurso($idCurso)->get();
    }


=======
>>>>>>> AranaBranch
    
}