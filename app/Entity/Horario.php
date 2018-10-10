<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Horario as mHorario;
use Jenssegers\Date\Date as Carbon;

class Horario extends \App\Entity\Base\Entity {

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

    static function getHorariosCompleto($idCurso){
        return mHorario::getHorariosCompleto($idCurso);
    }

    static function getHorarios($idCurso) {
        $model = new mHorario();
        return mHorario::getHorarios($idCurso)->get();
    }


    static function actualizarHorarios($idHorarios,$estadoAcreditacion) {
        $model = new mHorario();
        return mHorario::actualizarHorarios($idHorarios,$estadoAcreditacion);
    }

    static function getAvance($idHorario){
        return mHorario::getAvance($idHorario);
    }

    static function getAlumnosCalif($idHorario){
        return mHorario::getAlumnosCalif($idHorario);
    }

    static function getCantAlumnos($idHorario){
        return mHorario::getCantAlumnos($idHorario);
    }
    
}