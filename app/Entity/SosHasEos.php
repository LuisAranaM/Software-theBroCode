<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\SosHasEos as mSosHasEos;
use Jenssegers\Date\Date as Carbon;

class SosHasEos extends \App\Entity\Base\Entity {

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

    static function getSosHasEos(){
        $model=new mSosHasEos();
        return $model->getSosHasEos(self::getIdSemestre(),self::getEspecialidadUsuario())->get();
    }
    public function actualizarObjetivos($checks,$idUsuario){
        //dd($checks,$idUsuario);
        $data=[];

        if($checks!=NULL){
            foreach ($checks as $check) {
                $aux=explode('-',$check);
                $registro=['ID_SOS'=>$aux[0],
                            'ID_EOS'=>$aux[1],
                            'ID_SEMESTRE'=>self::getIdSemestre(),
                            'ID_ESPECIALIDAD'=>self::getEspecialidadUsuario(),
                            'FECHA_REGISTRO'=>Carbon::now(),
                            'FECHA_ACTUALIZACION'=>Carbon::now(),
                            'USUARIO_MODIF'=>$idUsuario,
                            'ESTADO'=>1];
                $data[]=$registro;
            }
        }   

        $model= new mSosHasEos();
        

        if ($model->actualizarObjetivos(self::getIdSemestre(),self::getEspecialidadUsuario(),$data,$idUsuario)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }

    
}