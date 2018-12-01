<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Semestre as mSemestre;
use Jenssegers\Date\Date as Carbon;

class Semestre extends \App\Entity\Base\Entity {

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

    static function getSemestres($tipo=null,$vistaResultado=null)
    {
        return mSemestre::getSemestres($tipo,self::getIdSemestre(),$vistaResultado)->get();
    }

    function actualizarSemestreSistema($idSemestre,$idUsuario){

       $model= new mSemestre();

       if ($model->actualizarSemestreSistema($idSemestre,$idUsuario)){
        return true;
    }else{
        $this->setMessage('Hubo un error en el servidor de base de datos');
        return false;
    }
}

function crearSemestre($dataSemestre,$idUsuario){
 $hoy=Carbon::now();

 $model= new mSemestre();

 $semestre=[
    'FECHA_INICIO'=> $dataSemestre['fInicio'],  
    'FECHA_FIN'=> $dataSemestre['fFin'],  
    'FECHA_ALERTA'=> $dataSemestre['fAlerta'] ,  
    'ANHO'=> $dataSemestre['anho'] ,  
    'CICLO'=> $dataSemestre['ciclo'] ,  

    'FECHA_REGISTRO'=>$hoy,     
    'FECHA_ACTUALIZACION'=>$hoy,
    'USUARIO_MODIF'=>$idUsuario,      
    'ESTADO'=>-1];

    if($semestre['FECHA_INICIO']>$semestre['FECHA_FIN']){
        $this->setMessage('La fecha de inicio no puede ser después que la fecha de fin');
        return false;
    }

    if(!($semestre['FECHA_ALERTA']>=$semestre['FECHA_INICIO'] and $semestre['FECHA_ALERTA']<=$semestre['FECHA_FIN'])){
        $this->setMessage('La fecha de alerta debe ser durante el ciclo');
        return false;
    }
    if ($model->verificarSemestre($semestre)){
     $this->setMessage('Ya existe el semestre '.$semestre['ANHO'].'-'.$semestre['CICLO']. ' en la base de datos');
     return false;
 }

 if ($model->crearSemestre($semestre)){
    return true;
}
else{
    $this->setMessage('Hubo un error en el servidor de base de datos');
    return false;
}
}

function editarSemestre($dataSemestre,$idUsuario){
 $hoy=Carbon::now();

 $model= new mSemestre();

 $semestre=[
    'ID_SEMESTRE'=> $dataSemestre['idSemestre'],  
    'FECHA_INICIO'=> $dataSemestre['fInicio'],  
    'FECHA_FIN'=> $dataSemestre['fFin'],  
    'FECHA_ALERTA'=> $dataSemestre['fAlerta'] ,  
    'ANHO'=> $dataSemestre['anho'] ,  
    'CICLO'=> $dataSemestre['ciclo'] ,  
    'FECHA_ACTUALIZACION'=>$hoy,
    'USUARIO_MODIF'=>$idUsuario];

    if($semestre['FECHA_INICIO']>$semestre['FECHA_FIN']){
        $this->setMessage('La fecha de inicio no puede ser después que la fecha de fin');
        return false;
    }

    if(!($semestre['FECHA_ALERTA']>=$semestre['FECHA_INICIO'] and $semestre['FECHA_ALERTA']<=$semestre['FECHA_FIN'])){
        $this->setMessage('La fecha de alerta debe ser durante el ciclo');
        return false;
    }
    if ($model->verificarSemestre($semestre,1)){
     $this->setMessage('Ya existe el semestre '.$semestre['ANHO'].'-'.$semestre['CICLO']. ' en la base de datos');
     return false;
 }

 if ($model->editarSemestre($semestre)){
    return true;
}
else{
    $this->setMessage('Hubo un error en el servidor de base de datos');
    return false;
}
}

}