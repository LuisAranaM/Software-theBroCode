<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Jenssegers\Date\Date as Carbon;
use App\Models\Descripcion as mDescripcion;

class Descripcion extends \App\Entity\Base\Entity {

    protected $_idEspecialidad;
    protected $_idSemestre;
    protected $_nombre;
    protected $_fechaRegistro;
    protected $_fechaActualizacion;
    protected $_usuarioModif;
    protected $_estado;
    protected $_idCriterio;
    
    static function getDescripcionesId($idInd) {
        $model = new mDescripcion();
        return mDescripcion::getDescripcionesId($idInd)->get();
    }

    static function insertDescripcion($indicador,$descripcion,$nombre,$orden){
        $model =new mDescripcion();
        return $model->insertDescripcion($indicador,$descripcion,$nombre,$orden);
    }
    static function updateDescripcion($id, $desc,$nombre,$orden){
        $model =new mDescripcion();
        return $model->updateDescripcion($id, $desc,$nombre,$orden);
    }
    static function deleteDescripcion($id){
        $model =new mDescripcion();
        $model->deleteDescripcion($id);
    }
}