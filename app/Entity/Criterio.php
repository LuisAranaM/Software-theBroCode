<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Jenssegers\Date\Date as Carbon;
use App\Models\Criterio as mCriterio;

class Criterio extends \App\Entity\Base\Entity {

    protected $_nombre;
    protected $_descripcion;
    protected $_fechaRegistro;
    protected $_fechaActualizacion;
    protected $_usuarioModif;
    protected $_estado;
    
    public function setFromAuth($crit) {
        $this->setValue('_nombre',$crit->NOMBRE);
        $this->setValue('_descripcion',$crit->DESCRIPCION);
        $this->setValue('_fechaRegistro',$crit->FECHA_REGISTRO);
        $this->setValue('_fechaActualizacion',$crit->FECHA_ACTUALIZACION);
        $this->setValue('_usuarioModif',$crit->USUARIO_MODIF);
        $this->setValue('_estado',$crit->ESTADO);        
    }   

    static function getCriterios() {
        $model = new mCriterio();
        return mCriterio::getCriterios()->get();
    }
<<<<<<< HEAD
    
    static function getCriteriosbyIdCurso($idCurso) {
        $model = new mCriterio();
        return mCriterio::getCriteriosbyIdCurso($idCurso)->get();
    }

=======
>>>>>>> AranaBranch
    static function insertCriterio($nombre, $desc){
        $model =new mCriterio();
        return $model->insertCriterio($nombre,$desc);
    }
}