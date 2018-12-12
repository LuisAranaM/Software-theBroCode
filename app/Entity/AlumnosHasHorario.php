<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\AlumnosHasHorario as mAlumnosHasHorario;
use Jenssegers\Date\Date as Carbon;

class AlumnosHasHorario extends \App\Entity\Base\Entity {

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

    static function getAlumnosByIdHorario($idCurso){

        return mAlumnosHasHorario::getAlumnosByIdHorario($idCurso);
    }
    static function getAlumnoXHorario($idHorario){
        return mAlumnosHasHorario::getAlumnoXHorario($idHorario);
    }

    static function getAvanceByAlumno($idHorario,$idCurso){
        $model=new mAlumnosHasHorario();
        return $model->getAvanceByAlumno($idHorario,$idCurso)->get();
    }
    
}