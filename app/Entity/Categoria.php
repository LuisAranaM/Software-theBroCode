<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Jenssegers\Date\Date as Carbon;
use App\Models\Categoria as mCategoria;

class Categoria extends \App\Entity\Base\Entity {

    protected $_idEspecialidad;
    protected $_idSemestre;
    protected $_nombre;
    protected $_fechaRegistro;
    protected $_fechaActualizacion;
    protected $_usuarioModif;
    protected $_estado;
    protected $_idCriterio;
    
    public function setFromAuth($cat) {
        $this->setValue('_idEspecialidad',$cat->ID_ESPECIALIDAD);
        $this->setValue('_idSemestre',$cat->ID_SEMESTRE);
        $this->setValue('_nombre',$cat->NOMBRE);
        $this->setValue('_idResultado',$cat->ID_RESULTADO);
        $this->setValue('_fechaRegistro',$cat->FECHA_REGISTRO);
        $this->setValue('_fechaActualizacion',$cat->FECHA_ACTUALIZACION);
        $this->setValue('_usuarioModif',$cat->USUARIO_MODIF);
        $this->setValue('_estado',$cat->ESTADO);        
    }   

    static function getCategoriasId($idCrit) {
        $model = new mCategoria();
        return mCategoria::getCategoriasId($idCrit)->get();
    }
    static function getCategorias() {
        $model = new mCategoria();
        return mCategoria::getCategorias()->get();


    }
    static function insertCategoria($categoria, $criterio){
        $model =new mCategoria();
        return $model->insertCategoria($categoria, $criterio);
    }
}