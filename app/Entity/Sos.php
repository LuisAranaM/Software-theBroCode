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

    static function getObjetivosTotales() {
        $model = new mSos();
        return mSos::getObjetivosTotales(self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }


    function copiarObj($idSemestreCopiar,$idUsuario){
        $model=new mSos();
        $objetivos=self::getinformacionObj($idSemestreCopiar);

        if ($model->copiarObj(self::getIdSemestre(),self::getEspecialidadUsuario(),$objetivos,$idUsuario)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }

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

    static function getinformacionObj($idSemestre){
        $model= new mSos();
        $infoObj=$model->getinformacionObj($idSemestre,self::getEspecialidadUsuario());
       /* $resultados=array();
        $contRes=0;
        foreach ($info as $fila) {
            $resultadoNuevo=['NOMBRE_SOS'=>$fila->NOMBRE_SOS,
            'NOMBRE_EOS'=>$fila->NOMBRE_EOS];

            $resultados[]=$resultadoNuevo;
            $contRes++;
        }*/
        return $infoObj;
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
        $registro=['NOMBRESOS'=>$textSos,        
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