<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Curso as mCurso;
use Jenssegers\Date\Date as Carbon;

class Curso extends \App\Entity\Base\Entity {

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

    static function getCursosYHorarios(){
        return mCurso::getCursosYHorarios();
    }

    static function getCursoByIdHorario($idHorario) {
        $model = new mCurso();
        return mCurso::getCursoByIdHorario($idHorario)->get();
    }

    static function getCursos() {
        $model = new mCurso();
        return mCurso::getCursos()->get();
    }

    static function buscarCursos($nomCurso){
        $model= new mCurso();
        return $model->buscarCursos($nomCurso)->get();
    }

}