<?php

namespace App\Entity;

use \Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\UsuariosHasEspecialidades as mUsuariosHasEspecialidades;
use Jenssegers\Date\Date as Carbon;

class UsuariosHasEspecialidades extends \App\Entity\Base\Entity {

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

       function verComoEspecialidad($idEspecialidad,$idUsuario){

         $model= new mUsuariosHasEspecialidades();
         $hoy=Carbon::now();
         $dataEspecialidadUsuario=array();
         $dataEspecialidadUsuario=[
            'ID_USUARIO'=>$idUsuario,
            'ID_ESPECIALIDAD'=>$idEspecialidad,
            'FECHA_REGISTRO'=>$hoy,
            'FECHA_ACTUALIZACION'=>$hoy,
            'USUARIO_MODIF'=>$idUsuario,
            'ESTADO'=>1,
         ];
         //dd($dataEspecialidadUsuario);

         if ($model->verComoEspecialidad($dataEspecialidadUsuario)){
            return true;
        }else{
            $this->setMessage('Hubo un error en el servidor de base de datos');
            return false;
        }
    }
    
}