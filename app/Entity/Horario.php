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
        return mHorario::getHorariosCompleto($idCurso,self::getIdSemestre());
    }
    //Retorna datos los horarios de un curso, y de los profesores a cargo.
    static function getHorarios($idCurso) {
        $model = new mHorario();
        return mHorario::getHorarios($idCurso,self::getIdSemestre())->get();
    }

    static function getHorarioByIdHorario($idHorario) {
        $model = new mHorario();
        return mHorario::getHorarioByIdHorario($idHorario)->get();
    }

    static function actualizarHorarios($idHorarios,$estadoEv,$usuario) {
        //dd($idHorarios,$estadoEv,$usuario);
        $model = new mHorario();
        if ($model->actualizarHorarios($idHorarios,$estadoEv,$usuario)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }

    function eliminarEvaluacion($idHorario,$usuario){
        $model= new mHorario();
        
        if ($model->eliminarEvaluacion($idHorario,$usuario)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
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

    static function getIdHorario($nombre,$idCurso){
        $model = new mHorario();
        if($model->getIdHorario($nombre,$idCurso,self::getIdSemestre(),self::getEspecialidadUsuario())->first())

            return $model->getIdHorario($nombre,$idCurso,self::getIdSemestre(),self::getEspecialidadUsuario())->first()->ID_HORARIO;
        else
            return $model->getIdHorario($nombre,$idCurso,self::getIdSemestre(),self::getEspecialidadUsuario())->first();
    }

    
}