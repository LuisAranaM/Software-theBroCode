<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Sos as mSos;
use Jenssegers\Date\Date as Carbon;

class Sos extends \App\Entity\Base\Entity {

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

    static function getObjetivosEstudiante(){
        
        return mSos::getObjetivosEstudiante(self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }

    public function eliminarSos($IDSOS,$nombreSOS,$usuario){
        //dd($data['idAlumno']);
        $registro=['ID_SOS'=>$IDSOS, 
            'NOMBRESOS'=>$nombreSOS,          
            'ID_SEMESTRE'=>self::getIdSemestre(),
            'ID_ESPECIALIDAD'=>self::getEspecialidadUsuario(),            
            'FECHA_REGISTRO'=>Carbon::now(),
            'FECHA_ACTUALIZACION'=>Carbon::now(),
            'USUARIO_MODIF'=>$usuario,
            'ESTADO'=>1];
        //dd($registro);
        //Armamos lo que vamos a insertar
        //dd("HOLI");
        $model= new mSos();

        if ($model->eliminarSos($registro)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }

     public function editarSos($IDSOS,$nombreSOS,$usuario){
        //dd($data['idAlumno']);
        $registro=['ID_SOS'=>$IDSOS, 
            'NOMBRE'=>$nombreSOS,          
            'ID_SEMESTRE'=>self::getIdSemestre(),
            'ID_ESPECIALIDAD'=>self::getEspecialidadUsuario(),            
            'FECHA_REGISTRO'=>Carbon::now(),
            'FECHA_ACTUALIZACION'=>Carbon::now(),
            'USUARIO_MODIF'=>$usuario,
            'ESTADO'=>1];
        //dd($registro);
        //Armamos lo que vamos a insertar
        //dd("HOLI");
        $model= new mSos();

        if ($model->editarSos($registro)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }

    
     public function agregarSos($textSos,$usuario){
        //dd($data['textSos']);
        $registro=['NOMBRE'=>$textSos,        
            'ID_SEMESTRE'=>self::getIdSemestre(),
            'ID_ESPECIALIDAD'=>self::getEspecialidadUsuario(),            
            'FECHA_REGISTRO'=>Carbon::now(),
            'FECHA_ACTUALIZACION'=>Carbon::now(),
            'USUARIO_MODIF'=>$usuario,
            'ESTADO'=>1];
        //dd($registro);
        //Armamos lo que vamos a insertar
        //dd("HOLI");
        $model= new mSos();

        if ($model->agregarSos($registro)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }  
}