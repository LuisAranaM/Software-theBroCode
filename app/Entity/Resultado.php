<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Jenssegers\Date\Date as Carbon;
use App\Models\Resultado as mResultado;

class Resultado extends \App\Entity\Base\Entity {

    protected $_nombre;
    protected $_descripcion;
    protected $_fechaRegistro;
    protected $_fechaActualizacion;
    protected $_usuarioModif;
    protected $_estado;
    
    public function setFromAuth($resultado) {
        $this->setValue('_nombre',$resultado->NOMBRE);
        $this->setValue('_descripcion',$resultado->DESCRIPCION);
        $this->setValue('_idEspecialidad',$indicador->ID_ESPECIALIDAD);
        $this->setValue('_idSemestre',$indicador->ID_SEMESTRE);
        $this->setValue('_fechaRegistro',$resultado->FECHA_REGISTRO);
        $this->setValue('_fechaActualizacion',$resultado->FECHA_ACTUALIZACION);
        $this->setValue('_usuarioModif',$resultado->USUARIO_MODIF);
        $this->setValue('_estado',$resultado->ESTADO);        
    }   

    static function getResultados() {
        $model = new mResultado();
        return mResultado::getResultados(self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }
    
    static function getResultadosbyIdCurso($idCurso) {
        $model = new mResultado();
        return mResultado::getResultadosbyIdCurso($idCurso)->get();
    }


    static function insertResultado($nombre, $desc){
        $model =new mResultado();
        return $model->insertResultado($nombre,$desc,self::getIdSemestre(),self::getEspecialidadUsuario());
    }
}