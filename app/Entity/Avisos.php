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
        return mAvisos::getAvisos(self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }

    static function insertAvisos($id, $desc,$fechaIni,$fechaFin){
        $model = new mAvisos();
        return $model->insertAviso($id, $desc,$fechaIni,$fechaFin, self::getIdSemestre(), self::getEspecialidadUsuario());
    }
    
}