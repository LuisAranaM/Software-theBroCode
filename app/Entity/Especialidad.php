<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Especialidad as mEspecialidad;
use Jenssegers\Date\Date as Carbon;

class Especialidad extends \App\Entity\Base\Entity {

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

    static function getEspecialidades(){
        $model = new mEspecialidad();
        return $model->getEspecialidades()->get();
    }
    

    function crearEspecialidad($nombreEsp,$idUsuario){
        $hoy=Carbon::now();

        $model= new mEspecialidad();

        $especialidad=[
            'NOMBRE'=> $nombreEsp ,  
            'FECHA_REGISTRO'=>$hoy,     
            'FECHA_ACTUALIZACION'=>$hoy,
            'USUARIO_MODIF'=>$idUsuario,      
            'ESTADO'=>1];

            if($model->buscarEspecialidad($nombreEsp)){
                $this->setMessage('Ya existe una especialidad llamada '.$nombreEsp);
                return false;
            }

            if ($model->crearEspecialidad($especialidad)){
                return true;
            }
            else{
                $this->setMessage('Hubo un error en el servidor de base de datos');
                return false;
            }
        }

          function editarEspecialidad($dataEspecialidad,$idUsuario){
        $hoy=Carbon::now();
        //dd($dataEspecialidad);
        $model= new mEspecialidad();

        $especialidad=[
            'ID_ESPECIALIDAD'=>$dataEspecialidad['idEspecialidad'],
            'NOMBRE'=> $dataEspecialidad['nombEspecialidadEditar'] ,  
            'FECHA_ACTUALIZACION'=>$hoy,
            'USUARIO_MODIF'=>$idUsuario];

            if($model->buscarEspecialidad($especialidad['NOMBRE'],$especialidad['ID_ESPECIALIDAD'])){
                $this->setMessage('Ya existe una especialidad llamada '.$especialidad['NOMBRE']);
                return false;
            }

            if ($model->editarEspecialidad($especialidad)){
                return true;
            }
            else{
                $this->setMessage('Hubo un error en el servidor de base de datos');
                return false;
            }
        }

     
}