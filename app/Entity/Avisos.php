<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Jenssegers\Date\Date as Carbon;
use App\Models\Avisos as mAvisos;

class Avisos extends \App\Entity\Base\Entity {

    protected $_nombre;
    protected $_descripcion;
    protected $_fechaRegistro;
    protected $_fechaActualizacion;
    protected $_usuarioModif;
    protected $_estado;

    static function getAvisos() {
        $model = new mAvisos();
        
        return mAvisos::getAvisos(self::getIdSemestre(),self::getEspecialidadUsuario());
    }

    static function getAvisosActuales() {
        $model = new mAvisos();
        return $model->getAvisosActuales(self::getIdSemestre(),self::getEspecialidadUsuario());
    }

    static function insertAvisos($desc,$fechaIni,$fechaFin){
        $model = new mAvisos();
        return $model->insertAviso($desc,$fechaIni,$fechaFin, self::getIdSemestre(), self::getEspecialidadUsuario());
    }

    static function eliminarAviso($idAviso){
        $model = new mAvisos();
        if ($model->eliminarAviso($idAviso)) {
            return true;
        } else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }

    
}