<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\Eos as mEos;
use Jenssegers\Date\Date as Carbon;

class Eos extends \App\Entity\Base\Entity {

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

    static function getObjetivosEducacionales(){
        
        return mEos::getObjetivosEducacionales(self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }

    public function eliminarEos($IDEOS,$nombreEOS,$usuario){
        //dd($data['idAlumno']);
        $registro=['ID_EOS'=>$IDEOS, 
        'NOMBREEOS'=>$nombreEOS,          
        'ID_SEMESTRE'=>self::getIdSemestre(),
        'ID_ESPECIALIDAD'=>self::getEspecialidadUsuario(),            
        'FECHA_REGISTRO'=>Carbon::now(),
        'FECHA_ACTUALIZACION'=>Carbon::now(),
        'USUARIO_MODIF'=>$usuario,
        'ESTADO'=>1];
        //dd($registro);
        //Armamos lo que vamos a insertar
        //dd("HOLI");
        $model= new mEos();

        if ($model->eliminarEos($registro)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }

    
    public function editarEos($IDEOS,$nombreEOS,$usuario){
        //dd($data['idAlumno']);
        $registro=['ID_EOS'=>$IDEOS, 
        'NOMBRE'=>$nombreEOS,          
        'ID_SEMESTRE'=>self::getIdSemestre(),
        'ID_ESPECIALIDAD'=>self::getEspecialidadUsuario(),            
        'FECHA_REGISTRO'=>Carbon::now(),
        'FECHA_ACTUALIZACION'=>Carbon::now(),
        'USUARIO_MODIF'=>$usuario,
        'ESTADO'=>1];
        //dd($registro);
        //Armamos lo que vamos a insertar
        //dd("HOLI");
        $model= new mEos();

        if ($model->editarEos($registro)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }


    public function agregarEos($textEos,$usuario){
        //dd($data['textSos']);
        $registro=['NOMBRESEOS'=>$textEos,        
        'ID_SEMESTRE'=>self::getIdSemestre(),
        'ID_ESPECIALIDAD'=>self::getEspecialidadUsuario(),            
        'FECHA_REGISTRO'=>Carbon::now(),
        'FECHA_ACTUALIZACION'=>Carbon::now(),
        'USUARIO_MODIF'=>$usuario,
        'ESTADO'=>1];
        //dd($registro);
        //Armamos lo que vamos a insertar
        //dd("HOLI");
        $model= new mEos();

        if ($model->agregarEos($registro)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }  
    
}