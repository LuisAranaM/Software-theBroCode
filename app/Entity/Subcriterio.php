<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Subcriterio as mSubcriterio;
use Jenssegers\Date\Date as Carbon;

class Subcriterio extends \App\Entity\Base\Entity {

	protected $_idCriterio;
    protected $_idEspecialidad;
    protected $_idSemestre;
    protected $_nombre;
    protected $_desc1;
    protected $_desc2;
    protected $_desc3;
    protected $_desc4;
    protected $_fechaRegistro;
    protected $_fechaActualizacion;
    protected $_usuarioModif;
    protected $_estado;
    
    public function setFromAuth($subCrit) {
        $this->setValue('_idCriterio',$subCrit->ID_CRITERIO);
        $this->setValue('_idEspecialidad',$subCrit->ID_ESPECIALIDAD);
        $this->setValue('_idSemestre',$subCrit->ID_SEMESTRE);
        $this->setValue('_nombre',$subCrit->NOMBRE);
        $this->setValue('_desc1',$subCrit->DESCRIPCION_1);
        $this->setValue('_desc2',$subCrit->DESCRIPCION_2);
        $this->setValue('_desc3',$subCrit->DESCRIPCION_3);
        $this->setValue('_desc4',$subCrit->DESCRIPCION_4);
        $this->setValue('_fechaRegistro',$subCrit->FECHA_REGISTRO);
        $this->setValue('_fechaActualizacion',$subCrit->FECHA_ACTUALIZACION);
        $this->setValue('_usuarioModif',$subCrit->USUARIO_MODIF);
        $this->setValue('_estado',$subCrit->ESTADO);        
    }   

    static function insertSubCriterio($idCrit,$idEsp,$idSem,$nombre, $desc1,$desc2,$desc3,$desc4){
        $model =new mSubcriterio();
        $model->insertSubCriterio($idCrit,$idEsp,$idSem,$nombre, $desc1,$desc2,$desc3,$desc4);
    }

    static function getSubCriteriosId($idCat){
        $model =new mSubcriterio();
        return $model::getSubCriteriosId($idCat)->get();
    }
    static function getSubCriterios(){
        $model =new mSubcriterio();
        return $model::getSubCriterios()->get();
    }
    static function getSubCriterioId($idInd){
        $model =new mSubcriterio();
        return $model::getSubCriterioId($idInd)->get();
    }
    static function updateSubcriterio($indicador){
        $model =new mSubcriterio();
        return $model::updateSubcriterio($indicador);
    }

}