<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Semestre as mSemestre;
use Jenssegers\Date\Date as Carbon;

class Semestre extends \App\Entity\Base\Entity {

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

    static function getSemestres()
    {
        return mSemestre::getSemestres()->get();
    }

    function actualizarSemestreSistema($idSemestre,$idUsuario){
     
       $model= new mSemestre();

       if ($model->actualizarSemestreSistema($idSemestre,$idUsuario)){
        return true;
    }else{
        $this->setMessage('Hubo un error en el servidor de base de datos');
        return false;
    }
}

}