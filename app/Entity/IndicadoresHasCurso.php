<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\IndicadoresHasCurso as mIndicadoresHasCurso;
use Jenssegers\Date\Date as Carbon;

class IndicadoresHasCurso extends \App\Entity\Base\Entity {

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

    static function getIndicadoresbyIdCurso($idCurso) {
        $model = new mIndicadoresHasCurso();
        return mIndicadoresHasCurso::getIndicadoresbyIdCurso($idCurso,self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }

    static function actualizarIndicadoresCurso($idIndicadores,$estadoIndicadores,$idCurso, $id){
        //dd($idIndicadores,$estadoIndicadores,$idCurso, $id);
        $model = new mIndicadoresHasCurso();
        if ($model->actualizarIndicadoresCurso($idIndicadores,$estadoIndicadores,$idCurso, $id,self::getEspecialidadUsuario(),self::getIdSemestre())){
            return true;
        }else{
            //$this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }
    
}